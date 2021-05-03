<#1>
<?php
srag\Plugins\SrGeogebra\Repository::getInstance()->installTables();
?>
<#2>
<?php
use srag\Plugins\SrGeogebra\Config\Repository;
use srag\Plugins\SrGeogebra\Forms\BaseAdvancedGeogebraFormGUI;

Repository::getInstance()->setValue(BaseAdvancedGeogebraFormGUI::KEY_ENABLE_3D, true);
?>
<#3>
<?php
use srag\Plugins\SrGeogebra\Config\Repository;
use srag\Plugins\SrGeogebra\Config\ConfigAdvancedGeogebraFormGUI;

Repository::getInstance()->setValue(ConfigAdvancedGeogebraFormGUI::KEY_DEFAULT_ALIGNMENT, "left");
?>
<#4>
<?php
use srag\Plugins\SrGeogebra\Config\Repository;
use srag\Plugins\SrGeogebra\Config\ConfigAdvancedGeogebraFormGUI;

Repository::getInstance()->setValue(ConfigAdvancedGeogebraFormGUI::KEY_IMMUTABLE, []);
?>
<#5>
<?php
use srag\Plugins\SrGeogebra\Upload\UploadService;

function is_ggb_xml_element($element, $loop_num, &$valid_page_element, &$ggb_found) {
    $max_loops = 20;
    if ($loop_num > $max_loops) {
        return false;
    }

    if (isset($element->Plugged) && (string)$element->Plugged["PluginName"] === "SrGeogebra") {
        $valid_page_element = $element;
        $ggb_found = true;
        return true;
    } else {
        $children = $element->children();

        foreach ($children as $child) {
            $result = is_ggb_xml_element($child, $loop_num + 1, $valid_page_element, $ggb_found);
            if ($result === false) {
                continue;
            } else {
                return true;
            }
        }
    }
    return false;
}

global $DIC;
$ilDB = $DIC['ilDB'];

$result = $ilDB->query("SELECT page_id, parent_id, content FROM page_object");

$resultAssoc = $ilDB->fetchAll($result);

foreach ($resultAssoc as $entry) {
    libxml_use_internal_errors(true);
    $doc = new DOMDocument('1.0', 'utf-8');
    $doc->loadXML($entry["content"]);
    $errors = libxml_get_errors();

    if (!empty($errors)) {
        continue;
    }

    $xml = new SimpleXMLElement($entry["content"]);

    $ggb_found = false;
    $valid_page_element = null;

    if (!isset($xml->PageContent)) {
        continue;
    } else {
        foreach ($xml->PageContent as $page_element) {
            is_ggb_xml_element($page_element, 1, $valid_page_element, $ggb_found);
        }
    }

    if (!$ggb_found) {
        continue;
    }

    $plugin_name = (string) $valid_page_element->Plugged->attributes()->PluginName;
    $file_names = $valid_page_element->Plugged->xpath("//PluggedProperty[@Name='fileName']");

    if (!is_null($plugin_name) && !empty($plugin_name) && $plugin_name === "SrGeogebra") {
        $page_id = $entry["page_id"];
        $parent_id = $entry["parent_id"];

        $counter = 0;
        foreach ($file_names as $file_entry) {
            $counter++;
            $file_name = (string) $file_entry[0];

            // Check if already converted (contains /)
            if (preg_match('/^([\s\S]+)\/([\s\S]+)\/([\s\S]+)$/', $file_name)) {
                continue;
            }

            $old_file_location = sprintf("%s/%s/geogebra/%s", ILIAS_WEB_DIR, CLIENT_ID, $file_name);

            if (file_exists($old_file_location) && !empty($page_id) && !empty($parent_id)) {
                $new_file_name = UploadService::evaluateFileName($file_name, $page_id, $parent_id);
                $new_file_location = sprintf("%s/%s/geogebra/%s", ILIAS_WEB_DIR, CLIENT_ID, $new_file_name);

                if (!is_dir(dirname($new_file_location))) {
                    mkdir(dirname($new_file_location), 0777, true);
                }

                copy($old_file_location, $new_file_location);

                $file_entry[0] = $new_file_name;
                $result_xml = str_replace("<" . "?xml version=\"1.0\"?" . ">\n", '', $xml->asXML());

                $update_query = "UPDATE page_object SET content = ". $ilDB->quote($result_xml, 'text')
                    . " WHERE page_id = " . $ilDB->quote($page_id, 'integer')
                    . " AND parent_id = " . $ilDB->quote($parent_id, 'integer');

                $ilDB->manipulate($update_query);
            }
        }
    }
}

// Delete remaining, lingering, old files
$old_file_directory = sprintf("%s/%s/geogebra/*", ILIAS_WEB_DIR, CLIENT_ID);
$files = glob($old_file_directory);
foreach ($files as $file){
    if (is_file($file)) {
        unlink($file);
    }
}
?>
