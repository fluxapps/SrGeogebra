<?php

namespace srag\ActiveRecordConfig\SrGeogebra;

use srag\CustomInputGUIs\SrGeogebra\PropertyFormGUI\ConfigPropertyFormGUI;

/**
 * Class ActiveRecordConfigFormGUI
 *
 * @package    srag\ActiveRecordConfig\SrGeogebra
 *
 * @author     studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 *
 * @deprecated Please use PropertyFormGUI from instead
 */
abstract class ActiveRecordConfigFormGUI extends ConfigPropertyFormGUI
{

    /**
     * @var string
     *
     * @deprecated
     */
    const LANG_MODULE = ActiveRecordConfigGUI::LANG_MODULE_CONFIG;
    /**
     * @var string
     *
     * @deprecated
     */
    protected $tab_id;


    /**
     * ActiveRecordConfigFormGUI constructor
     *
     * @param ActiveRecordConfigGUI $parent
     * @param string                $tab_id
     *
     * @deprecated
     */
    public function __construct(ActiveRecordConfigGUI $parent, string $tab_id)
    {
        $this->tab_id = $tab_id;

        parent::__construct($parent);
    }


    /**
     * @inheritDoc
     *
     * @deprecated
     */
    protected function initCommands()/*: void*/
    {
        $this->addCommandButton(ActiveRecordConfigGUI::CMD_UPDATE_CONFIGURE . "_" . $this->tab_id, $this->txt("save"));
    }


    /**
     * @inheritDoc
     *
     * @deprecated
     */
    protected function initId()/*: void*/
    {

    }


    /**
     * @inheritDoc
     *
     * @deprecated
     */
    protected function initTitle()/*: void*/
    {
        $this->setTitle($this->txt($this->tab_id));
    }
}
