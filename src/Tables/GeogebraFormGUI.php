<?php

namespace srag\Plugins\SrGeogebra\Tables;

use ilFileInputGUI;
use ilLanguage;
use ilPropertyFormGUI;
use ilSrGeogebraPlugin;
use ilSrGeogebraPluginGUI;
use ilTextInputGUI;

class GeogebraFormGUI extends ilPropertyFormGUI
{

    /**
     * @var ilSrGeogebraPlugin
     */
    protected $pl;
    /**
     * @var array
     */
    protected $properties;
    /**
     * @var ilSrGeogebraPluginGUI
     */
    protected $parent_gui;
    /**
     * @var ilLanguage
     */
    protected $lng;


    public function __construct(ilSrGeogebraPluginGUI $parent_gui, $properties = array())
    {
        parent::__construct();

        global $DIC;
        $this->lng = $DIC->language();
        $this->id = 'srgg_create';
        $this->pl = new ilSrGeogebraPlugin();
        $this->properties = $properties;

        $this->parent_gui = $parent_gui;

        $this->setFormAction($DIC->ctrl()->getFormAction($parent_gui));
        $this->initForm();
    }


    protected function initForm()
    {
        $title = new ilTextInputGUI($this->pl->txt("form_title"), "srgg_title");
        $title->setRequired(true);
        $this->addItem($title);

        $file = new ilFileInputGUI($this->pl->txt("form_upload"), "srgg_file");
        $file->setSuffixes(array('ggb'));
        $this->addItem($file);

        /*
        if (empty($this->properties)) {
            $this->setTitle($this->pl->txt('form_create_marzipano'));
            $file->setRequired(true);
            $this->addCommandButton(ilMarzipanoPageComponentPluginGUI::CMD_CREATE, $this->lng->txt('create'));
        } else {
            $this->setTitle($this->pl->txt('form_edit_marzipano'));
            $this->addCommandButton(ilMarzipanoPageComponentPluginGUI::CMD_UPDATE, $this->lng->txt('update'));
            $file->setValue($this->properties["legacyFileName"]);
            $title->setValue($this->properties["title"]);
        }
        */

        $this->addCommandButton(ilSrGeogebraPluginGUI::CMD_CANCEL, $this->lng->txt('cancel'));
    }
}