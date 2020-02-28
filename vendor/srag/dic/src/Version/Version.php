<?php

namespace srag\DIC\SrGeogebra\Version;

/**
 * Class Version
 *
 * @package srag\DIC\SrGeogebra\Version
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
final class Version implements VersionInterface
{

    /**
     * Version constructor
     */
    public function __construct()
    {

    }


    /**
     * @inheritDoc
     */
    public function getILIASVersion() : string
    {
        return ILIAS_VERSION_NUMERIC;
    }


    /**
     * @inheritDoc
     */
    public function isEqual(string $version) : bool
    {
        return (version_compare($this->getILIASVersion(), $version) === 0);
    }


    /**
     * @inheritDoc
     */
    public function isGreater(string $version) : bool
    {
        return (version_compare($this->getILIASVersion(), $version) > 0);
    }


    /**
     * @inheritDoc
     */
    public function isLower(string $version) : bool
    {
        return (version_compare($this->getILIASVersion(), $version) < 0);
    }


    /**
     * @inheritDoc
     */
    public function isMaxVersion(string $version) : bool
    {
        return (version_compare($this->getILIASVersion(), $version) <= 0);
    }


    /**
     * @inheritDoc
     */
    public function isMinVersion(string $version) : bool
    {
        return (version_compare($this->getILIASVersion(), $version) >= 0);
    }


    /**
     * @inheritDoc
     */
    public function is53() : bool
    {
        return $this->isMinVersion(self::ILIAS_VERSION_5_3);
    }


    /**
     * @inheritDoc
     */
    public function is54() : bool
    {
        return $this->isMinVersion(self::ILIAS_VERSION_5_4);
    }


    /**
     * @inheritDoc
     */
    public function is60() : bool
    {
        return $this->isMinVersion(self::ILIAS_VERSION_6_0);
    }
}
