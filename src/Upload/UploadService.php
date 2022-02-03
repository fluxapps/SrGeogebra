<?php

namespace srag\Plugins\SrGeogebra\Upload;

use ilFileUtils;
use ILIAS\FileUpload\DTO\ProcessingStatus;
use ILIAS\FileUpload\Location;

class UploadService
{
    const DATA_FOLDER = "geogebra";
    const FILE_SUFFIX = "ggb";


    public function handleUpload($form, $file_name, $page_id, $parent_id) {
        global $DIC;

        $upload = $DIC->upload();

        if (!$upload->hasUploads() || $upload->hasBeenProcessed()) {
            $form->setValuesByPost();

            return $form->getHTML();
        }

        $upload->process();
        $uploadResult = array_values($upload->getResults())[0];

        if (!$uploadResult || $uploadResult->getStatus()->getCode() !== ProcessingStatus::OK) {
            $form->setValuesByPost();

            return $form->getHTML();
        }

        $file_name = self::evaluateFileName($file_name, $page_id, $parent_id);

        $upload->moveOneFileTo(
            $uploadResult,
            self::DATA_FOLDER,
            Location::WEB,
            $file_name
        );

        return $file_name;
    }


    public function uploadAllowed() {
        global $DIC;

        $whitelist = ilFileUtils::getValidExtensions();

        // Error if file extension "ggb" is not whitelisted upon plugin activation
        if (!in_array(UploadService::FILE_SUFFIX, $whitelist)) {
            return false;
        }

        return true;
    }


    public static function evaluateFileName($file_name, $page_id, $parent_id, $inc = null) {
        global $DIC;

        $legacyFileName = $file_name;

        $file_name = rtrim($file_name, ".ggb");
        $file_name = sprintf("obj_%s/page_%s/%s", $parent_id, $page_id, $file_name);
        $file_name_extra = is_null($inc) ? "" : sprintf("_%s", $inc);
        $file_name .= $file_name_extra . ".ggb";
        $path = sprintf("%s/%s", self::DATA_FOLDER, $file_name);

        // If path not found -> File name is available
        if (!$DIC->filesystem()->web()->has($path)) {
            return $file_name;
        }

        // Otherwise evaluate a valid file name by appending an incremented number
        // Calculate increment
        $inc = is_null($inc) ? 2 : $inc + 1;

        return self::evaluateFileName($legacyFileName, $page_id, $parent_id, $inc);
    }

}