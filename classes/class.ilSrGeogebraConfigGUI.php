<?php

require_once __DIR__ . "/../vendor/autoload.php";

use srag\Plugins\SrGeogebra\Config\Repository;
use srag\Plugins\SrGeogebra\Utils\SrGeogebraTrait;
use srag\DIC\SrGeogebra\DICTrait;

/**
 * Class ilSrGeogebraConfigGUI
 *
 * Generated by SrPluginGenerator v1.3.4
 *
 * @author studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class ilSrGeogebraConfigGUI extends ilPluginConfigGUI
{

    use DICTrait;
    use SrGeogebraTrait;
    const PLUGIN_CLASS_NAME = ilSrGeogebraPlugin::class;
    const CMD_CONFIGURE = "configure";
    const CMD_UPDATE_CONFIGURE = "updateConfigure";
    const LANG_MODULE = "config";
    const TAB_CONFIGURATION = "configuration";


    /**
     * ilSrGeogebraConfigGUI constructor
     */
    public function __construct()
    {

    }


    /**
     * @inheritDoc
     */
    public function performCommand(/*string*/ $cmd)/*:void*/
    {
        $this->setTabs();

        $next_class = self::dic()->ctrl()->getNextClass($this);

        switch (strtolower($next_class)) {
            default:
                $cmd = self::dic()->ctrl()->getCmd();

                switch ($cmd) {
                    case self::CMD_CONFIGURE:
                    case self::CMD_UPDATE_CONFIGURE:
                        $this->{$cmd}();
                        break;

                    default:
                        break;
                }
                break;
        }
    }


    /**
     *
     */
    protected function setTabs()/*: void*/
    {
        self::dic()->tabs()->addTab(self::TAB_CONFIGURATION, self::plugin()->translate("configuration", self::LANG_MODULE), self::dic()->ctrl()
            ->getLinkTargetByClass(self::class, self::CMD_CONFIGURE));

        self::dic()->locator()->addItem(ilSrGeogebraPlugin::PLUGIN_NAME, self::dic()->ctrl()->getLinkTarget($this, self::CMD_CONFIGURE));
    }


    /**
     *
     */
    protected function configure()/*: void*/
    {
        self::dic()->tabs()->activateTab(self::TAB_CONFIGURATION);

        ini_set("xdebug.var_display_max_children", '-1');
        ini_set("xdebug.var_display_max_data", '-1');
        ini_set("xdebug.var_display_max_depth", '-1');

        $form = self::srGeogebra()->config()->factory()->newFormInstance($this);


        $conf_rep = Repository::getInstance();
        $fields = $conf_rep->getFields();


        $tpl = new ilTemplate(
            "tpl.geogebra_config.html",
            false,
            false,
            ilSrGeogebraPlugin::DIRECTORY
        );

        //die(var_dump($fields));
        $values = [];

        foreach ($fields as $key => $value) {
            $fetched_value = $conf_rep->getValue($key);
            if ($key === "default_alignment" || $key === "appName") {
                $key = $key . "_" . $fetched_value;
                $tpl->setVariable($key, "selected='selected'");
            } else if ($key === "immutable") {
                foreach ($fetched_value as $immutable_key) {
                    $tpl->setVariable("immutable_" . $immutable_key . "_checked", "checked='checked'");
                }
            } else if ($key !== "immutable") {
                if (is_bool($fetched_value)) {
                    if ($fetched_value === true) {
                        $tpl->setVariable($key . "_checked", "checked='checked'");
                    }
                    $fetched_value = intval($fetched_value);
                }
                $tpl->setVariable($key, $fetched_value);


            }
        }

        self::output()->output($tpl->get());
    }


    /**
     *
     */
    protected function updateConfigure()/*: void*/
    {
        //die(var_dump($_POST));
        self::dic()->tabs()->activateTab(self::TAB_CONFIGURATION);

        $conf_rep = Repository::getInstance();
        $form = self::srGeogebra()->config()->factory()->newFormInstance($this);

        if (!$form->storeForm()) {
            self::output()->output($form);

            return;
        }

        //die(var_dump($form->getItems()));

        foreach ($form->getItems() as $item) {
            if ($item instanceof ilCheckboxInputGUI) {
                $conf_rep->setValue($item->getPostvar(), $item->getChecked());
            } else {
                $conf_rep->setValue($item->getPostvar(), $item->getValue());
            }
        }

        self::dic()->ctrl()->redirect($this, self::CMD_CONFIGURE);
    }
}
