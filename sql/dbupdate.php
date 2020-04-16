<#1>
<?php
srag\Plugins\SrGeogebra\Repository::getInstance()->installTables();
?>
<#2>
<?php
use srag\Plugins\SrGeogebra\Config\Repository;
use srag\Plugins\SrGeogebra\Forms\BaseAdvancedGeogebraFormGUI;

Repository::getInstance()->setValue(BaseAdvancedGeogebraFormGUI::KEY_ENABLE_3D, true);
?>
<#3>
<?php
use srag\Plugins\SrGeogebra\Config\Repository;
use srag\Plugins\SrGeogebra\Config\ConfigAdvancedGeogebraFormGUI;

Repository::getInstance()->setValue(ConfigAdvancedGeogebraFormGUI::KEY_DEFAULT_ALIGNMENT, "left");
?>
<#4>
<?php
use srag\Plugins\SrGeogebra\Config\Repository;
use srag\Plugins\SrGeogebra\Config\ConfigAdvancedGeogebraFormGUI;

Repository::getInstance()->setValue(ConfigAdvancedGeogebraFormGUI::KEY_IMMUTABLE, []);
?>
