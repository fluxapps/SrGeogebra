<?php

/* Copyright (c) 1998-2017 ILIAS open source, Extended GPL, see docs/LICENSE */

include_once('./Services/COPage/classes/class.ilPageComponentPluginExporter.php');

use srag\Plugins\SrGeogebra\Upload\UploadService;

/**
 * Class ilTestPageComponentExporter
 */
class ilSrGeogebraImporter extends ilPageComponentPluginImporter
{
    /**
     * Import xml representation
     *
     * @param	string			$a_entity
     * @param	string			$a_id
     * @param	string			$a_xml
     * @param	ilImportMapping	$a_mapping
     */
    public function importXmlRepresentation($a_entity, $a_id, $a_xml, $a_mapping)
    {
        $new_id = self::getPCMapping($a_id, $a_mapping);

        $properties = self::getPCProperties($new_id);
        $version = self::getPCVersion($new_id);

        // TODO: No getAbsoluteImportDirectory or such exists, so manually search after the gbb file
        $import_gbb_dir = $this->getImportDirectory() . "/Plugins/" . ilSrGeogebraPlugin::PLUGIN_NAME;
        $gbb_import_files = [];
        $set_num = 1;
        do {
            $import_gbb_set_dir = $import_gbb_dir . "/set_" . $set_num;
            $exp_num = 1;
            do {
                $import_gbb_set_exp_dir = $import_gbb_set_dir . "/expDir_" . $exp_num;
                $gbb_file = $import_gbb_set_exp_dir . "/" . $properties["fileName"];
                if (file_exists($gbb_file)) {
                    $gbb_import_files[] = $gbb_file;
                }
                $exp_num++;
            } while (is_dir($import_gbb_set_exp_dir));
            $set_num++;
        } while (is_dir($import_gbb_set_dir));
        if (empty($gbb_import_files)) {
            throw new LogicException("No gbb files found for " . $properties["fileName"] . " in " . $import_gbb_dir);
        }
        if (count($gbb_import_files) !== 1) {
            throw new LogicException("Multiple gbb files found for " . $properties["fileName"] . " in " . $import_gbb_dir);
        }

        $page_id = explode(":", $new_id)[1];
        $obj_id = $a_mapping->getMapping("Services/Object", "obj", substr(explode("/", $properties["fileName"])[0], 4));

        $import_gbb_file = $gbb_import_files[0];

        $properties["fileName"] = $properties["legacyFileName"] = UploadService::evaluateFileName(basename($import_gbb_file), $page_id, $obj_id);

        $dest_gbb_file = ILIAS_WEB_DIR . '/' . CLIENT_ID . '/' . UploadService::DATA_FOLDER . '/' . $properties["fileName"];

        ilUtil::makeDirParents(dirname($dest_gbb_file));
        copy($import_gbb_file, $dest_gbb_file);

        self::setPCProperties($new_id, $properties);
        self::setPCVersion($new_id, $version);
    }
}