<?php

namespace srag\Plugins\SrGeogebra\Forms;

use ilSrGeogebraPluginGUI;

class SettingsAdvancedGeogebraFormGUI extends BaseAdvancedGeogebraFormGUI
{
    protected $properties;


    public function __construct(ilSrGeogebraPluginGUI $parent, $properties) {
        $this->properties = $properties;
        parent::__construct($parent);
    }


    /**
     * @param string $key
     * @param mixed  $value
     */
    protected function storeValue($key, $value)
    {

    }


    /**
     * @param string $key
     *
     * @return mixed
     */
    protected function getValue($key)
    {
        $parent_result = parent::getValue($key);

        if (!is_null($parent_result)) {
            return $parent_result;
        }

        return $this->properties["advanced_" . $key];
    }


    /**
     *
     */
    protected function initTitle()
    {
        $this->setTitle($this->txt('form_title_edit'));
    }


    /**
     *
     */
    protected function initCommands()
    {
        $this->addCommandButton(ilSrGeogebraPluginGUI::CMD_UPDATE_ADVANCED_PROPERTIES, self::plugin()->translate("save", "form"));
        $this->addCommandButton(ilSrGeogebraPluginGUI::CMD_CANCEL, self::plugin()->translate("cancel", "form"));
    }
}