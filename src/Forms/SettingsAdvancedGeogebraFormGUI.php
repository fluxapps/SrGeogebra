<?php

namespace srag\Plugins\SrGeogebra\Forms;

use ilSrGeogebraPluginGUI;
use srag\Plugins\SrGeogebra\Config\ConfigAdvancedGeogebraFormGUI;
use srag\Plugins\SrGeogebra\Config\Repository;

class SettingsAdvancedGeogebraFormGUI extends BaseAdvancedGeogebraFormGUI
{

    /**
     * @var array
     */
    protected $properties;
    /**
     * @var array
     */
    protected $immutable_values;


    public function __construct(ilSrGeogebraPluginGUI $parent, $properties) {
        $this->properties = $properties;
        $this->immutable_values = Repository::getInstance()->getValue(ConfigAdvancedGeogebraFormGUI::KEY_IMMUTABLE);
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

        if (strpos($key, "default_") !== 0) {
            if (in_array($key, $this->immutable_values)) {
                return Repository::getInstance()->getValue($key);
            }
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


    protected function initFields()
    {
        parent::initFields();

        foreach (Repository::getInstance()->getValue(ConfigAdvancedGeogebraFormGUI::KEY_IMMUTABLE) as $immutable) {
            if (strpos($immutable, "default_") !== 0) {
                $this->fields[$immutable][self::PROPERTY_DISABLED] = true;
            }
        }
    }
}