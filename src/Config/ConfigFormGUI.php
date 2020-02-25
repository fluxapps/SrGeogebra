<?php

namespace srag\Plugins\SrGeogebra\Config;

use ilCheckboxInputGUI;
use ilColorPickerInputGUI;
use ilNumberInputGUI;
use ilSelectInputGUI;
use srag\Plugins\SrGeogebra\Utils\SrGeogebraTrait;
use ilSrGeogebraConfigGUI;
use ilSrGeogebraPlugin;
use ilTextInputGUI;
use srag\ActiveRecordConfig\SrGeogebra\Config\Config;
use srag\CustomInputGUIs\SrGeogebra\PropertyFormGUI\PropertyFormGUI;

/**
 * Class ConfigFormGUI
 *
 * Generated by SrPluginGenerator v1.3.4
 *
 * @package srag\Plugins\SrGeogebra\Config
 *
 * @author studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class ConfigFormGUI extends PropertyFormGUI
{

    use SrGeogebraTrait;
    const PLUGIN_CLASS_NAME = ilSrGeogebraPlugin::class;
    const KEY_APP_NAME = "appName";
    const KEY_WIDTH = "width";
    const KEY_HEIGHT = "height";
    const KEY_BORDER_COLOR = "borderColor";
    const KEY_ENABLE_RIGHT = "enableRightClick";
    const KEY_ENABLE_LABEL_DRAGS = "enableLabelDrags";
    const KEY_ENABLE_SHIFT_ZOOM = "enableShiftDragZoom";
    const KEY_SHOW_ZOOM = "showZoomButtons";
    const KEY_ERROR_DIALOGS = "errorDialogsActive";
    const KEY_SHOW_MENU_BAR = "showMenuBar";
    const KEY_SHOW_TOOL_BAR = "showToolBar";
    const KEY_SHOW_TOOL_BAR_HELP = "showToolBarHelp";
    const KEY_SHOW_ALGEBRA_INPUT = "showAlgebraInput";
    //const KEY_CUSTOM_TOOL_BAR = "customToolBar";
    const KEY_LANGUAGE = "language";
    const KEY_ALLOW_STYLE_BAR = "allowStyleBar";
    const KEY_USE_BROWSER_FOR_JS = "useBrowserForJS";
    const KEY_SHOW_LOGGING = "showLogging";
    const KEY_CAPTURING_THRESHOLD = "capturingThreshold";
    const KEY_ENABLE_3D = "enable3d";
    const KEY_ENABLE_CAS = "enableCAS";
    const KEY_ALGEBRA_INPUT_POSITION = "algebraInputPosition";
    const KEY_PREVENT_FOCUS = "preventFocus";
    const KEY_AUTO_HEIGHT = "autoHeight";
    const KEY_ALLOW_UPSCALE = "allowUpscale";
    const KEY_PLAY_BUTTON = "playButton";
    const KEY_SCALE = "scale";
    const KEY_SHOW_ANIMATION_BUTTON = "showAnimationButton";
    const KEY_SHOW_FULLSCREEN_BUTTON = "showFullscreenButton";
    const KEY_SHOW_SUGGESTION_BUTTONS = "showSuggestionButtons";
    const KEY_SHOW_START_TOOLTIP = "showStartTooltip";
    const KEY_ROUNDING = "rounding";
    const KEY_BUTTON_SHADOWS = "buttonShadows";
    const KEY_BUTTON_ROUNDING = "buttonRounding";
    const LANG_MODULE = ilSrGeogebraConfigGUI::LANG_MODULE;


    /**
     * ConfigFormGUI constructor
     *
     * @param ilSrGeogebraConfigGUI $parent
     */
    public function __construct(ilSrGeogebraConfigGUI $parent)
    {
        parent::__construct($parent);
    }


    /**
     * @inheritDoc
     */
    protected function getValue(/*string*/ $key)
    {
        switch ($key) {
            default:
                return self::srGeogebra()->config()->getValue($key);
        }
    }


    /**
     * @inheritDoc
     */
    protected function initCommands()/*: void*/
    {
        $this->addCommandButton(ilSrGeogebraConfigGUI::CMD_UPDATE_CONFIGURE, $this->txt("save"));
    }


    /**
     * @inheritDoc
     */
    protected function initFields()/*: void*/
    {
        $this->fields = [
            self::KEY_APP_NAME => [
                self::PROPERTY_CLASS    => ilSelectInputGUI::class,
                self::PROPERTY_OPTIONS => [
                    "classic" => "classic",
                    "graphing" => "graphing",
                    "geometry" => "geometry",
                    "3d" => "3d"
                ]
            ],
            self::KEY_WIDTH => [
                self::PROPERTY_CLASS    => ilNumberInputGUI::class
            ],
            self::KEY_HEIGHT => [
                self::PROPERTY_CLASS    => ilNumberInputGUI::class
            ],
            self::KEY_BORDER_COLOR => [
                self::PROPERTY_CLASS    => ilColorPickerInputGUI::class
            ],
            self::KEY_ENABLE_RIGHT => [
                self::PROPERTY_CLASS    => ilCheckboxInputGUI::class
            ],
            self::KEY_ENABLE_LABEL_DRAGS => [
                self::PROPERTY_CLASS    => ilCheckboxInputGUI::class
            ],
            self::KEY_ENABLE_SHIFT_ZOOM => [
                self::PROPERTY_CLASS    => ilCheckboxInputGUI::class
            ],
            self::KEY_SHOW_ZOOM => [
                self::PROPERTY_CLASS    => ilCheckboxInputGUI::class
            ],
            self::KEY_ERROR_DIALOGS => [
                self::PROPERTY_CLASS    => ilCheckboxInputGUI::class
            ],
            self::KEY_SHOW_MENU_BAR => [
                self::PROPERTY_CLASS    => ilCheckboxInputGUI::class
            ],
            self::KEY_SHOW_TOOL_BAR => [
                self::PROPERTY_CLASS    => ilCheckboxInputGUI::class
            ],
            self::KEY_SHOW_TOOL_BAR_HELP => [
                self::PROPERTY_CLASS    => ilCheckboxInputGUI::class
            ],
            self::KEY_SHOW_ALGEBRA_INPUT => [
                self::PROPERTY_CLASS    => ilCheckboxInputGUI::class
            ],
            self::KEY_LANGUAGE => [
                self::PROPERTY_CLASS    => ilTextInputGUI::class
            ],
            self::KEY_ALLOW_STYLE_BAR => [
                self::PROPERTY_CLASS    => ilCheckboxInputGUI::class
            ],
            self::KEY_USE_BROWSER_FOR_JS => [
                self::PROPERTY_CLASS    => ilCheckboxInputGUI::class
            ],
            self::KEY_SHOW_LOGGING => [
                self::PROPERTY_CLASS    => ilCheckboxInputGUI::class
            ],
            self::KEY_CAPTURING_THRESHOLD => [
                self::PROPERTY_CLASS    => ilNumberInputGUI::class,
                "allowDecimals" => true
            ],
            self::KEY_ENABLE_3D => [
                self::PROPERTY_CLASS    => ilCheckboxInputGUI::class
            ],
            self::KEY_ENABLE_CAS => [
                self::PROPERTY_CLASS    => ilCheckboxInputGUI::class
            ],
            self::KEY_ALGEBRA_INPUT_POSITION => [
                self::PROPERTY_CLASS    => ilTextInputGUI::class
            ],
            self::KEY_PREVENT_FOCUS => [
                self::PROPERTY_CLASS    => ilCheckboxInputGUI::class
            ],
            self::KEY_AUTO_HEIGHT => [
                self::PROPERTY_CLASS    => ilCheckboxInputGUI::class
            ],
            self::KEY_ALLOW_UPSCALE => [
                self::PROPERTY_CLASS    => ilCheckboxInputGUI::class
            ],
            self::KEY_PLAY_BUTTON => [
                self::PROPERTY_CLASS    => ilCheckboxInputGUI::class
            ],
            self::KEY_SCALE => [
                self::PROPERTY_CLASS    => ilNumberInputGUI::class,
                "allowDecimals" => true
            ],
            self::KEY_SHOW_ANIMATION_BUTTON => [
                self::PROPERTY_CLASS    => ilCheckboxInputGUI::class
            ],
            self::KEY_SHOW_FULLSCREEN_BUTTON => [
                self::PROPERTY_CLASS    => ilCheckboxInputGUI::class
            ],
            self::KEY_SHOW_SUGGESTION_BUTTONS => [
                self::PROPERTY_CLASS    => ilCheckboxInputGUI::class
            ],
            self::KEY_SHOW_START_TOOLTIP => [
                self::PROPERTY_CLASS    => ilCheckboxInputGUI::class
            ],
            self::KEY_ROUNDING => [
                self::PROPERTY_CLASS    => ilTextInputGUI::class
            ],
            self::KEY_BUTTON_SHADOWS => [
                self::PROPERTY_CLASS    => ilCheckboxInputGUI::class
            ],
            self::KEY_BUTTON_ROUNDING => [
                self::PROPERTY_CLASS    => ilNumberInputGUI::class,
                "allowDecimals" => true
            ]
        ];
        // TODO: Implement ConfigFormGUI
    }


    /**
     * @inheritDoc
     */
    protected function initId()/*: void*/
    {

    }


    /**
     * @inheritDoc
     */
    protected function initTitle()/*: void*/
    {
        $this->setTitle($this->txt("configuration"));
    }


    /**
     * @inheritDoc
     */
    protected function storeValue(/*string*/ $key, $value)/*: void*/
    {
        switch ($key) {
            default:
                self::srGeogebra()->config()->setValue($key, $value);
                break;
        }
    }
}
