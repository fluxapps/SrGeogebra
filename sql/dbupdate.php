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
global $DIC;
$ilDB = $DIC->database();

$result = $ilDB->query("SELECT page_id, parent_id, content FROM page_object");

$resultAssoc = $ilDB->fetchAll($result);

foreach ($resultAssoc as $entry) {
    $xml = new SimpleXMLElement($entry["content"]);

    if (!isset($xml->PageContent->Plugged)) {
        continue;
    }

    $plugin_name = (string) $xml->PageContent->Plugged->attributes()->PluginName;
    $file_name = (string) $xml->PageContent->Plugged->xpath("PluggedProperty[@Name='fileName']")[0];

    if (!is_null($plugin_name) && !empty($plugin_name) && $plugin_name === "SrGeogebra") {
        $page_id = $entry["page_id"];
        $parent_id = $entry["parent_id"];

        $old_file_location = sprintf("./data/default/geogebra/%s", $file_name);

        if (file_exists($old_file_location) && !empty($page_id) && !empty($parent_id)) {
            $new_file_name = UploadService::evaluateFileName($file_name, $page_id, $parent_id);
            $new_file_location = sprintf("./data/default/geogebra/%s", $new_file_name);

            rename($old_file_location, $new_file_location);

            $prop_file_name = $xml->PageContent->Plugged->xpath("PluggedProperty[@Name='fileName']");
            $prop_legacy_file_name = $xml->PageContent->Plugged->xpath("PluggedProperty[@Name='legacyFileName']");
            $prop_file_name[0][0] = $new_file_name;
            $prop_legacy_file_name[0][0] = $new_file_name;

            $update_query = sprintf("UPDATE page_object SET content = %s WHERE page_id = %s AND parent_id = %s", $ilDB->quote(str_replace("<?xml version=\"1.0\"?>\n", '', $xml->asXML()), 'text'), $page_id, $parent_id);

            $ilDB->query($update_query);
        }
    }
}
?>
