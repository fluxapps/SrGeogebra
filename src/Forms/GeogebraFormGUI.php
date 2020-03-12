<?php

namespace srag\Plugins\SrGeogebra\Forms;

use ilCheckboxInputGUI;
use ilColorPickerInputGUI;
use ilFileInputGUI;
use ilNumberInputGUI;
use ilSelectInputGUI;
use ilSrGeogebraPluginGUI;
use srag\Plugins\SrGeogebra\Config\Repository;
use srag\Plugins\SrGeogebra\Utils\SrGeogebraTrait;
use ilSrGeogebraConfigGUI;
use ilSrGeogebraPlugin;
use ilTextInputGUI;
use srag\CustomInputGUIs\SrGeogebra\PropertyFormGUI\PropertyFormGUI;

/**
 * Class GeogebraFormGUI
 *
 * Generated by SrPluginGenerator v1.3.4
 *
 * @package srag\Plugins\SrGeogebra\Forms
 *
 * @author studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class GeogebraFormGUI extends PropertyFormGUI
{

    use SrGeogebraTrait;
    const PLUGIN_CLASS_NAME = ilSrGeogebraPlugin::class;
    const KEY_TITLE = "title";
    const KEY_FILE = "file";
    const KEY_WIDTH = "width";
    const KEY_HEIGHT = "height";
    const KEY_DRAG_ZOOM = "enableShiftDragZoom";
    const KEY_RESET = "showResetIcon";
    const LANG_MODULE = "form";
    const MODE_CREATE = 1;
    const MODE_EDIT = 2;

    protected $mode;
    protected $properties;


    /**
     * ConfigFormGUI constructor
     *
     * @param $parent
     */
    public function __construct($parent, $properties = "")
    {
        if (empty($properties)) {
            $this->mode = self::MODE_CREATE;
        } else {
            $this->mode = self::MODE_EDIT;
            $this->properties = $properties;
        }

        parent::__construct($parent);
    }


    /**
     * @inheritDoc
     */
    protected function getValue(/*string*/ $key)
    {
        if ($this->mode === self::MODE_CREATE) {
            switch ($key) {
                case "width":
                case "height":
                case "enableShiftDragZoom":
                case "showResetIcon":
                    $adjustedKey = "default_" . $key;
                    return Repository::getInstance()->getValue($adjustedKey);
            }

            return "";
        } else if ($this->mode === self::MODE_EDIT) {
            switch ($key) {
                case "title":
                    return $this->properties["title"];
                    break;
                case "file":
                    return $this->properties["legacyFileName"];
                    break;
                default:
                    return $this->properties["custom_" . $key];
            }
        }
    }


    /**
     * @inheritDoc
     */
    protected function initCommands()/*: void*/
    {
        if ($this->mode === self::MODE_CREATE) {
            $this->addCommandButton(ilSrGeogebraPluginGUI::CMD_CREATE, self::plugin()->translate("create", "form"));
        } else if ($this->mode === self::MODE_EDIT) {
            $this->addCommandButton(ilSrGeogebraPluginGUI::CMD_UPDATE, self::plugin()->translate("save", "form"));
        }

        $this->addCommandButton(ilSrGeogebraPluginGUI::CMD_CANCEL, self::plugin()->translate("cancel", "form"));
    }


    /**
     * @inheritDoc
     */
    protected function initFields()/*: void*/
    {
        $this->fields = [
            self::KEY_TITLE => [
                self::PROPERTY_CLASS    => ilTextInputGUI::class
            ],
            self::KEY_FILE => [
                self::PROPERTY_CLASS    => ilFileInputGUI::class
            ],
            self::KEY_WIDTH => [
                self::PROPERTY_CLASS    => ilNumberInputGUI::class,
                self::PROPERTY_REQUIRED => true
            ],
            self::KEY_HEIGHT => [
                self::PROPERTY_CLASS    => ilNumberInputGUI::class,
                self::PROPERTY_REQUIRED => true
            ],
            self::KEY_DRAG_ZOOM => [
                self::PROPERTY_CLASS    => ilCheckboxInputGUI::class
            ],
            self::KEY_RESET => [
                self::PROPERTY_CLASS    => ilCheckboxInputGUI::class
            ]
        ];

        if (empty($this->properties)) {
            $this->fields[self::KEY_TITLE][self::PROPERTY_REQUIRED] = true;
            $this->fields[self::KEY_FILE][self::PROPERTY_REQUIRED] = true;
        } else {
            $this->fields[self::KEY_TITLE]["setValue"] = $this->properties["title"];
            $this->fields[self::KEY_TITLE][self::PROPERTY_REQUIRED] = false;
            $this->fields[self::KEY_FILE][self::PROPERTY_REQUIRED] = false;
            $this->fields[self::KEY_FILE]["setValue"] = $this->properties["legacyFileName"];
        }
    }


    /**
     * @inheritDoc
     */
    protected function initId()/*: void*/
    {

    }


    /**
     * @inheritDoc
     */
    protected function initTitle()/*: void*/
    {
        if ($this->mode === self::MODE_CREATE) {
            $this->setTitle($this->txt('title_create'));
        } else if ($this->mode === self::MODE_EDIT) {
            $this->setTitle($this->txt('title_edit'));
        }
    }


    /**
     * @inheritDoc
     */
    protected function storeValue(/*string*/ $key, $value)/*: void*/
    {

    }
}
