<?php

namespace srag\CustomInputGUIs\SrGeogebra\PropertyFormGUI\Items;

use ilDateTime;
use ilFormPropertyGUI;
use ilFormSectionHeaderGUI;
use ILIAS\UI\Component\Input\Field\Input;
use ilNumberInputGUI;
use ilPropertyFormGUI;
use ilRadioOption;
use ilUtil;
use srag\CustomInputGUIs\SrGeogebra\MultiLineInputGUI\MultiLineInputGUI;
use srag\CustomInputGUIs\SrGeogebra\PropertyFormGUI\Exception\PropertyFormGUIException;
use srag\CustomInputGUIs\SrGeogebra\PropertyFormGUI\PropertyFormGUI;
use srag\CustomInputGUIs\SrGeogebra\TableGUI\TableGUI;
use srag\CustomInputGUIs\SrGeogebra\Template\Template;
use srag\CustomInputGUIs\SrGeogebra\UIInputComponentWrapperInputGUI\UIInputComponentWrapperInputGUI;
use srag\DIC\SrGeogebra\DICTrait;
use TypeError;

/**
 * Class Items
 *
 * @package srag\CustomInputGUIs\SrGeogebra\PropertyFormGUI\Items
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 *
 * @access  namespace
 */
final class Items
{

    use DICTrait;
    /**
     * @var bool
     */
    protected static $init = false;


    /**
     *
     */
    public static function init()/*: void*/
    {
        if (self::$init === false) {
            self::$init = true;

            $dir = __DIR__;
            $dir = "./" . substr($dir, strpos($dir, "/Customizing/") + 1);

            self::dic()->ui()->mainTemplate()->addCss($dir . "/css/input_gui_input.css");
        }
    }


    /**
     * @param string                              $key
     * @param array                               $field
     * @param ilPropertyFormGUI|ilFormPropertyGUI $parent_item
     * @param PropertyFormGUI|TableGUI            $parent
     *
     * @return ilFormPropertyGUI|ilFormSectionHeaderGUI|ilRadioOption
     */
    public static final function getItem($key, array $field, $parent_item, $parent)
    {
        /**
         * @var ilFormPropertyGUI|ilFormSectionHeaderGUI|ilRadioOption $item
         */
        if ($field[PropertyFormGUI::PROPERTY_CLASS] instanceof Input) {
            $item = new UIInputComponentWrapperInputGUI($field[PropertyFormGUI::PROPERTY_CLASS], $key);

            if (empty($item->getTitle())) {
                if (!$field["setTitle"]) {
                    $item->setTitle($parent->txt($key));
                }
            }

            if (empty($item->getInfo())) {
                if (!$field["setInfo"]) {
                    $item->setInfo($parent->txt($key . "_info", ""));
                }
            }
        } else {
            if (!class_exists($field[PropertyFormGUI::PROPERTY_CLASS])) {
                throw new PropertyFormGUIException("Class " . $field[PropertyFormGUI::PROPERTY_CLASS]
                    . " not exists!", PropertyFormGUIException::CODE_INVALID_PROPERTY_CLASS);
            }

            $item = new $field[PropertyFormGUI::PROPERTY_CLASS]();

            if ($item instanceof ilFormSectionHeaderGUI) {
                if (!$field["setTitle"]) {
                    $item->setTitle($parent->txt($key));
                }
            } else {
                if ($item instanceof ilRadioOption) {
                    if (!$field["setTitle"]) {
                        $item->setTitle($parent->txt($parent_item->getPostVar() . "_" . $key));
                    }

                    $item->setValue($key);
                } else {
                    if (!$field["setTitle"]) {
                        $item->setTitle($parent->txt($key));
                    }

                    $item->setPostVar($key);
                }
            }

            if (!$field["setInfo"]) {
                $item->setInfo($parent->txt($key . "_info", ""));
            }
        }

        self::setPropertiesToItem($item, $field);

        if ($item instanceof ilFormPropertyGUI) {
            if (isset($field[PropertyFormGUI::PROPERTY_VALUE])) {
                $value = $field[PropertyFormGUI::PROPERTY_VALUE];

                Items::setValueToItem($item, $value);
            }
        }

        return $item;
    }


    /**
     * @param ilFormPropertyGUI|ilFormSectionHeaderGUI|ilRadioOption $item
     *
     * @return mixed
     */
    public static function getValueFromItem($item)
    {
        if ($item instanceof MultiLineInputGUI) {
            //return filter_input(INPUT_POST,$item->getPostVar()); // Not work because MultiLineInputGUI modify $_POST
            return $_POST[$item->getPostVar()];
        }

        if (method_exists($item, "getChecked")) {
            return boolval($item->getChecked());
        }

        if (method_exists($item, "getDate")) {
            return $item->getDate();
        }

        if (method_exists($item, "getImage")) {
            return $item->getImage();
        }

        if (method_exists($item, "getValue") && !($item instanceof ilRadioOption)) {
            if ($item->getMulti()) {
                return $item->getMultiValues();
            } else {
                $value = $item->getValue();

                if ($item instanceof ilNumberInputGUI) {
                    $value = floatval($value);
                } else {
                    if (empty($value) && !is_array($value)) {
                        $value = "";
                    }
                }

                return $value;
            }
        }

        return null;
    }


    /**
     * @param ilFormPropertyGUI[] $inputs
     *
     * @return string
     */
    public static function renderInputs(array $inputs) : string
    {
        self::init();

        $input_tpl = new Template(__DIR__ . "/templates/input_gui_input.html");

        $input_tpl->setCurrentBlock("input");

        foreach ($inputs as $input) {
            $input_tpl->setVariableEscaped("TITLE", $input->getTitle());

            if ($input->getRequired()) {
                $input_tpl->setVariable("REQUIRED", self::output()->getHTML(new Template(__DIR__ . "/templates/input_gui_input_required.html", true, false)));
            }

            $input_html = self::output()->getHTML($input);
            $input_html = str_replace('<div class="help-block"></div>', "", $input_html);
            $input_tpl->setVariable("INPUT", $input_html);

            if ($input->getInfo()) {
                $input_info_tpl = new Template(__DIR__ . "/templates/input_gui_input_info.html");

                $input_info_tpl->setVariableEscaped("INFO", $input->getInfo());

                $input_tpl->setVariable("INFO", self::output()->getHTML($input_info_tpl));
            }

            if ($input->getAlert()) {
                $input_alert_tpl = new Template(__DIR__ . "/templates/input_gui_input_alert.html");
                $input_alert_tpl->setVariable("IMG",
                    self::output()->getHTML(self::dic()->ui()->factory()->image()->standard(ilUtil::getImagePath("icon_alert.svg"), self::dic()->language()->txt("alert"))));
                $input_alert_tpl->setVariableEscaped("TXT", $input->getAlert());
                $input_tpl->setVariable("ALERT", self::output()->getHTML($input_alert_tpl));
            }

            $input_tpl->parseCurrentBlock();
        }

        return self::output()->getHTML($input_tpl);
    }


    /**
     * @param ilFormPropertyGUI|ilFormSectionHeaderGUI|ilRadioOption $item
     * @param array                                                  $properties
     */
    private static function setPropertiesToItem($item, array $properties)/*: void*/
    {
        foreach ($properties as $property_key => $property_value) {
            $property = "";

            switch ($property_key) {
                case PropertyFormGUI::PROPERTY_DISABLED:
                    $property = "setDisabled";
                    break;

                case PropertyFormGUI::PROPERTY_MULTI:
                    $property = "setMulti";
                    break;

                case PropertyFormGUI::PROPERTY_OPTIONS:
                    $property = "setOptions";
                    $property_value = [$property_value];
                    break;

                case PropertyFormGUI::PROPERTY_REQUIRED:
                    $property = "setRequired";
                    break;

                case PropertyFormGUI::PROPERTY_CLASS:
                case PropertyFormGUI::PROPERTY_NOT_ADD:
                case PropertyFormGUI::PROPERTY_SUBITEMS:
                case PropertyFormGUI::PROPERTY_VALUE:
                    break;

                default:
                    $property = $property_key;
                    break;
            }

            if (!empty($property)) {
                if (!is_array($property_value)) {
                    $property_value = [$property_value];
                }

                call_user_func_array([$item, $property], $property_value);
            }
        }
    }


    /**
     * @param ilFormPropertyGUI|ilFormSectionHeaderGUI|ilRadioOption $item
     * @param mixed                                                  $value
     */
    public static function setValueToItem($item, $value)/*: void*/
    {
        if ($item instanceof MultiLineInputGUI) {
            $item->setValueByArray([
                $item->getPostVar() => $value
            ]);

            return;
        }

        if (method_exists($item, "setChecked")) {
            $item->setChecked($value);

            return;
        }

        if (method_exists($item, "setDate")) {
            if (is_string($value)) {
                $value = new ilDateTime($value, IL_CAL_DATE);
            }

            $item->setDate($value);

            return;
        }

        if (method_exists($item, "setImage")) {
            $item->setImage($value);

            return;
        }

        if (method_exists($item, "setValue") && !($item instanceof ilRadioOption)) {
            $item->setValue($value);
        }
    }


    /**
     * @param object $object
     * @param string $property
     *
     * @return mixed
     */
    public static function getter(/*object*/ $object,/*string*/ $property)
    {
        if (method_exists($object, $method = "get" . self::strToCamelCase($property))) {
            return $object->{$method}();
        }

        if (method_exists($object, $method = "is" . self::strToCamelCase($property))) {
            return $object->{$method}();
        }

        return null;
    }


    /**
     * @param object $object
     * @param string $property
     * @param mixed  $value
     */
    public static function setter(/*object*/ $object,/*string*/ $property, $value)/*: void*/
    {
        if (method_exists($object, $method = "set" . self::strToCamelCase($property))) {
            try {
                $object->{$method}($value);
            } catch (TypeError $ex) {
                try {
                    $object->{$method}(intval($value));
                } catch (TypeError $ex) {
                    $object->{$method}(boolval($value));
                }
            }
        }
    }


    /**
     * @param string $string
     *
     * @return string
     */
    public static function strToCamelCase($string)
    {
        return str_replace("_", "", ucwords($string, "_"));
    }


    /**
     * Items constructor
     */
    private function __construct()
    {

    }
}
