<?php

namespace srag\Plugins\SrGeogebra\Forms;

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
        /*
        $this->year = new ilSelectInputGUI(self::plugin()->translate("year", ilObjSrFinanceCockpitGUI::LANG_MODULE_VALUES), "year");
        $yearOptions = array();
        foreach (BudgetYear::getCollection()->where(array('ref_id' => $this->parent->ref_id))->get() as $year) {
            $yearOptions[$year->getId()] = $year->getYear();
        }
        $this->year->setOptions($yearOptions);
        $this->year->setRequired(true);
        $this->addItem($this->year);
        */

        $title = new ilTextInputGUI($this->pl->txt("form_title"), "srgg_title");
        $title->setRequired(true);
        $this->addItem($title);

        $file = new ilFileInputGUI($this->pl->txt("form_upload"), "srgg_file");
        $file->setSuffixes(array('ggb'));
        $this->addItem($file);

        $width = new \ilNumberInputGUI($this->pl->txt("form_width"), "width");
        $width->setRequired(true);
        $this->addItem($width);

        $height = new \ilNumberInputGUI($this->pl->txt("form_height"), "height");
        $height->setRequired(true);
        $this->addItem($height);

        /*
        $borderColor = new \ilColorPickerInputGUI($this->pl->txt("form_border_color"), "srgg_border_color");
        $borderColor->setRequired(true);
        $this->addItem($borderColor);
        */

        /*
        $reset = new \ilCheckboxInputGUI($this->pl->txt("form_fullscreen"), "srgg_fullscreen");
        $this->addItem($reset);
        */

        $zoom = new \ilCheckboxInputGUI($this->pl->txt("form_zoom"), "enableShiftDragZoom");
        $this->addItem($zoom);

        $reset = new \ilCheckboxInputGUI($this->pl->txt("form_reset"), "showResetIcon");
        $this->addItem($reset);

        // Test if creation form
        if (empty($this->properties)) {
            $this->setTitle($this->pl->txt('form_title_create'));
            $file->setRequired(true);
            $this->addCommandButton(ilSrGeogebraPluginGUI::CMD_CREATE, $this->lng->txt('create'));
        } else {
            $this->setTitle($this->pl->txt('form_title_edit'));
            $this->addCommandButton(ilSrGeogebraPluginGUI::CMD_UPDATE, $this->lng->txt('update'));
            $file->setValue($this->properties["legacyFileName"]);
            $title->setValue($this->properties["title"]);
        }

        $this->addCommandButton(ilSrGeogebraPluginGUI::CMD_CANCEL, $this->lng->txt('cancel'));
    }
}