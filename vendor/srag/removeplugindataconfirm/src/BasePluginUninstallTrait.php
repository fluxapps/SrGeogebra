<?php

namespace srag\RemovePluginDataConfirm\SrGeogebra;

use ilUIPluginRouterGUI;
use srag\DIC\SrGeogebra\DICTrait;
use srag\DIC\SrGeogebra\Util\LibraryLanguageInstaller;

/**
 * Trait BasePluginUninstallTrait
 *
 * @package srag\RemovePluginDataConfirm\SrGeogebra
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 *
 * @access  namespace
 */
trait BasePluginUninstallTrait
{

    use DICTrait;

    /**
     * @inheritDoc
     */
    public function updateDatabase()/* : void*/
    {
        if ($this->shouldUseOneUpdateStepOnly()) {
            $this->writeDBVersion(0);
        }

        return parent::updateDatabase();
    }


    /**
     * Delete your plugin data in this method
     */
    protected abstract function deleteData()/*: void*/ ;


    /**
     *
     */
    protected function installRemovePluginDataConfirmLanguages()/*:void*/
    {
        LibraryLanguageInstaller::getInstance()->withPlugin(self::plugin())->withLibraryLanguageDirectory(__DIR__
            . "/../lang")->updateLanguages();
    }


    /**
     * @param bool $remove_data
     *
     * @return bool
     *
     * @internal
     */
    protected final function pluginUninstall(bool $remove_data = true) : bool
    {
        $uninstall_removes_data = RemovePluginDataConfirmCtrl::getUninstallRemovesData();

        if ($uninstall_removes_data === null) {
            RemovePluginDataConfirmCtrl::saveParameterByClass();

            self::dic()->ctrl()->redirectByClass([
                ilUIPluginRouterGUI::class,
                RemovePluginDataConfirmCtrl::class
            ], RemovePluginDataConfirmCtrl::CMD_CONFIRM_REMOVE_DATA);

            return false;
        }

        $uninstall_removes_data = boolval($uninstall_removes_data);

        if ($remove_data) {
            if ($uninstall_removes_data) {
                $this->deleteData();
            }

            RemovePluginDataConfirmCtrl::removeUninstallRemovesData();
        }

        return true;
    }


    /**
     * @return bool
     */
    protected abstract function shouldUseOneUpdateStepOnly() : bool;
}
