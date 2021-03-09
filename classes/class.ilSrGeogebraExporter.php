<?php

/* Copyright (c) 1998-2017 ILIAS open source, Extended GPL, see docs/LICENSE */

use srag\Plugins\SrGeogebra\Upload\UploadService;

include_once('./Services/COPage/classes/class.ilPageComponentPluginExporter.php');

/**
 * Class ilTestPageComponentExporter
 */
class ilSrGeogebraExporter extends ilPageComponentPluginExporter
{
    public function init()
    {
        include_once('./Services/COPage/classes/class.ilCOPageDataSet.php');
        $this->ds = new ilCOPageDataSet();
          }


    /**
     * Get head dependencies
     *
     * @param string        entity
     * @param string        target release
     * @param array        ids
     * @return        array        array of array with keys "component", entity", "ids"
     */
    public function getXmlExportHeadDependencies($a_entity, $a_target_release, $a_ids)
    {
        // collect the files to export
        $file_ids = array();
        foreach ($a_ids as $id) {
            $properties = self::getPCProperties($id);
            if (isset($properties['fileName'])) {

                $file_ids[] =  $properties['fileName'];
            }
        }

        if (!empty(($file_ids))) {
            return array(
                array(
                    'component' => 'Modules/File',
                    'entity' => 'file',
                    'ids' => $file_ids)
            );
        }

        return array();
    }


    /**
     * Get xml representation
     *
     * @param string        entity
     * @param string        schema version
     * @param string        id
     * @return    string        xml string
     */
    public function getXmlRepresentation($a_entity, $a_schema_version, $a_id)
    {
        if ($a_entity == 'pgcp') {

            /** @var ilSrGeogebraPlugin $plugin */
            $plugin = ilPluginAdmin::getPluginObject(IL_COMP_SERVICE, 'COPage', 'pgcp', 'SrGeogebra');
            $prop = self::getPCProperties($a_id);
            $id = $prop['id'] + 0;
            //$data = $plugin->($id);


            $this->ds->setExportDirectories( ILIAS_WEB_DIR . '/' . CLIENT_ID . '/' . UploadService::DATA_FOLDER . '/export',  ILIAS_ABSOLUTE_PATH . '/'. ILIAS_WEB_DIR . '/' . CLIENT_ID . '/' . UploadService::DATA_FOLDER . '/exort');

            $src_gbb_file = ILIAS_WEB_DIR . '/' . CLIENT_ID . '/' . UploadService::DATA_FOLDER . '/' . $prop["fileName"];
            $export_gbb_file = $this->getAbsoluteExportDirectory() . "/" . $prop["fileName"];

            ilUtil::makeDirParents(dirname($export_gbb_file));
            copy($src_gbb_file, $export_gbb_file);

            return '<data>' . htmlentities(json_encode($prop, 1)) . '</data>';

            return $xml;
        } else {
            return $this->ds->getXmlRepresentation($a_entity, $a_schema_version, $a_id, '', true, true);
        }
    }

    /**
     * Get tail dependencies
     *
     * @param string        entity
     * @param string        target release
     * @param array        ids
     * @return        array        array of array with keys "component", entity", "ids"
     */
    public function getXmlExportTailDependencies($a_entity, $a_target_release, $a_ids)
    {
        return array();
    }

    /**
     * Returns schema versions that the component can export to.
     * ILIAS chooses the first one, that has min/max constraints which
     * fit to the target release. Please put the newest on top. Example:
     *
     *        return array (
     *        "4.1.0" => array(
     *            "namespace" => "http://www.ilias.de/Services/MetaData/md/4_1",
     *            "xsd_file" => "ilias_md_4_1.xsd",
     *            "min" => "4.1.0",
     *            "max" => "")
     *        );
     *
     *
     * @return        array
     */
    public function getValidSchemaVersions($a_entity)
    {
        return array(
            '5.3.0' => array(
                'namespace' => 'http://www.ilias.de/',
                //'xsd_file'     => 'pctpc_5_3.xsd',
                'uses_dataset' => false,
                'min' => '5.3.0',
                'max' => ''
            )
        );
    }
}
