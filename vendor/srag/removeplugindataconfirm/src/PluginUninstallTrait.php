<?php

namespace srag\RemovePluginDataConfirm\SrGeogebra;

/**
 * Trait PluginUninstallTrait
 *
 * @package srag\RemovePluginDataConfirm\SrGeogebra
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
trait PluginUninstallTrait
{

    use BasePluginUninstallTrait;


    /**
     * @return bool
     *
     * @internal
     */
    protected final function beforeUninstall() : bool
    {
        return $this->pluginUninstall();
    }


    /**
     * @internal
     */
    protected final function afterUninstall()/*: void*/
    {

    }
}
