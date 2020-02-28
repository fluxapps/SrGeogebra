<?php

namespace srag\CustomInputGUIs\SrGeogebra\MultiLineInputGUI;

use ilCalendarUtil;
use ilDate;
use ilDateTimeInputGUI;
use ilException;
use ilFormPropertyGUI;
use ilHiddenInputGUI;
use ilTableFilterItem;
use ilTemplate;
use ilTextAreaInputGUI;
use ilToolbarItem;
use ilUtil;
use srag\CustomInputGUIs\SrGeogebra\GlyphGUI\GlyphGUI;
use srag\CustomInputGUIs\SrGeogebra\Template\Template;
use srag\DIC\SrGeogebra\DICTrait;

/**
 * Class MultiLineInputGUI
 *
 * @package    srag\CustomInputGUIs\SrGeogebra\MultiLineInputGUI
 *
 * @author     studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 * @author     Michael Herren <mh@studer-raimann.ch>
 *
 * @deprecated Please switch to `MultiLineNewInputGUI`
 */
class MultiLineInputGUI extends ilFormPropertyGUI implements ilTableFilterItem, ilToolbarItem
{

    use DICTrait;
    /**
     * @var string
     *
     * @deprecated
     */
    const HOOK_IS_LINE_REMOVABLE = "hook_is_line_removable";
    /**
     * @var string
     *
     * @deprecated
     */
    const HOOK_IS_INPUT_DISABLED = "hook_is_disabled";
    /**
     * @var string
     *
     * @deprecated
     */
    const HOOK_BEFORE_INPUT_RENDER = "hook_before_render";
    /**
     * @var array
     *
     * @deprecated
     */
    protected $cust_attr = array();
    /**
     * @var
     *
     * @deprecated
     */
    protected $value;
    /**
     * @var array
     *
     * @deprecated
     */
    protected $inputs = array();
    /**
     * @var array
     *
     * @deprecated
     */
    protected $input_options = array();
    /**
     * @var array
     *
     * @deprecated
     */
    protected $hooks = array();
    /**
     * @var array
     *
     * @deprecated
     */
    protected $line_values = array();
    /**
     * @var string
     *
     * @deprecated
     */
    protected $template_dir = '';
    /**
     * @var array
     *
     * @deprecated
     */
    protected $post_var_cache = array();
    /**
     * @var bool
     *
     * @deprecated
     */
    protected $show_label = false;
    /**
     * @var bool
     *
     * @deprecated
     */
    protected $show_label_once = false;
    /**
     * @var array
     *
     * @deprecated
     */
    protected $hidden_inputs = array();
    /**
     * @var bool
     *
     * @deprecated
     */
    protected $position_movable = false;
    /**
     * @var int
     *
     * @deprecated
     */
    protected $counter = 0;
    /**
     * @var bool
     *
     * @deprecated
     */
    protected $show_info = false;


    /**
     * Constructor
     *
     * @param string $a_title   Title
     * @param string $a_postvar Post Variable
     *
     * @deprecated
     */
    public function __construct(/*string*/ $a_title = "", /*string*/ $a_postvar = "")
    {
        parent::__construct($a_title, $a_postvar);
        $this->setType("line_select");
        $this->setMulti(true);
        $this->initCSSandJS();
    }


    /**
     * @return string
     *
     * @deprecated
     */
    public function getHook(/*string*/ $key)/*: string*/
    {
        if (isset($this->hooks[$key])) {
            return $this->hooks[$key];
        }

        return false;
    }


    /**
     * @param string $key
     * @param array  $options
     *
     * @deprecated
     */
    public function addHook(/*string*/ $key, /*array*/ $options)/*: void*/
    {
        $this->hooks[$key] = $options;
    }


    /**
     * @param string $key
     *
     * @return bool
     *
     * @deprecated
     */
    public function removeHook(/*string*/ $key)/*: bool*/
    {
        if (isset($this->hooks[$key])) {
            unset($this->hooks[$key]);

            return true;
        }

        return false;
    }


    /**
     * @param ilFormPropertyGUI $input
     * @param array             $options
     *
     * @deprecated
     */
    public function addInput(ilFormPropertyGUI $input, /*: array*/ $options = array())/*: void*/
    {
        $this->inputs[$input->getPostVar()] = $input;

        $this->input_options[$input->getPostVar()] = $options;
        $this->counter++;
    }


    /**
     * @return string
     *
     * @deprecated
     */
    public function getTemplateDir()/*: string*/
    {
        return $this->template_dir;
    }


    /**
     * @param string $template_dir
     *
     * @deprecated
     */
    public function setTemplateDir(/*string*/ $template_dir)/*: void*/
    {
        $this->template_dir = $template_dir;
    }


    /**
     * @return boolean
     *
     * @deprecated
     */
    public function isShowLabel()/*: bool*/
    {
        return $this->show_label;
    }


    /**
     * @param boolean $show_label
     *
     * @deprecated
     */
    public function setShowLabel(/*bool*/ $show_label)/*: void*/
    {
        $this->show_label = $show_label;
    }


    /**
     * Get Options.
     *
     * @return array Options. Array ("value" => "option_text")
     *
     * @deprecated
     */
    public function getInputs()/*: array*/
    {
        return $this->inputs;
    }


    /**
     * @param bool $a_multi
     * @param bool $a_sortable
     * @param bool $a_addremove
     *
     * @deprecated
     */
    public function setMulti(/*bool*/ $a_multi, /*bool*/ $a_sortable = false, /*bool*/ $a_addremove = true)/*: void*/
    {
        $this->multi = $a_multi;
    }


    /**
     * Set Value.
     *
     * @param string $a_value Value
     *
     * @deprecated
     */
    public function setValue(/*string*/ $a_value)/*: void*/
    {
        foreach ($this->inputs as $key => $item) {
            if (method_exists($item, 'setValue')) {
                $item->setValue($a_value[$key]);
            } elseif ($item instanceof ilDateTimeInputGUI) {
                $item->setDate(new ilDate($a_value[$key], IL_CAL_DATE));
            }

            if (method_exists($item, 'setChecked')) {
                $item->setChecked($a_value[$key . '_checked']);
            }
        }
        $this->value = $a_value;
    }


    /**
     * Get Value.
     *
     * @return string|array Value
     *
     * @deprecated
     */
    public function getValue()
    {
        $out = array();
        foreach ($this->inputs as $key => $item) {
            $out[$key] = $item->getValue();
        }

        return $out;
    }


    /**
     * Set value by array
     *
     * @param array $a_values value array
     *
     * @deprecated
     */
    public function setValueByArray(/*array*/ $a_values)/*: void*/
    {
        $data = $a_values[$this->getPostVar()];
        if ($this->getMulti()) {
            $this->line_values = $data;
        } else {
            $this->setValue($data);
        }
    }


    /**
     * Check input, strip slashes etc. set alert, if input is not ok.
     *
     * @return boolean Input ok, true/false
     *
     * @deprecated
     */
    public function checkInput()/*: bool*/
    {
        $valid = true;
        // escape data
        $out_array = array();
        if (is_array($_POST[$this->getPostVar()]) && count($_POST[$this->getPostVar()]) > 0) {
            foreach ($_POST[$this->getPostVar()] as $item_num => $item) {
                foreach ($this->inputs as $input_key => $input) {
                    if (isset($item[$input_key])) {
                        $out_array[$item_num][$input_key] = (is_string($item[$input_key])) ? ilUtil::stripSlashes($item[$input_key]) : $item[$input_key];

                        if (method_exists($input, 'setValue')) {
                            $input->setValue($out_array[$item_num][$input_key]);
                        } elseif ($input instanceof ilDateTimeInputGUI) {
                            $input->setDate(new ilDate($out_array[$item_num][$input_key], IL_CAL_DATE));
                        }
                    }
                }
            }
        }

        $_POST[$this->getPostVar()] = $out_array;
        if ($this->getRequired() && !trim(implode("", $_POST[$this->getPostVar()]))) {
            $valid = false;
        }
        // validate

        if ($this->getMulti()) {
            if (count($this->line_values) > 0) {
                foreach ($this->line_values as $inputs) {
                    foreach ($inputs as $input_key => $input_value) {
                        $input = $this->inputs[$input_key];
                        $_POST[$input->getPostVar()] = $input_value;
                        if (!$input->checkInput()) {
                            $valid = false;
                        }
                    }
                }
            }
        } else {
            foreach ($this->inputs as $input_key => $input) {
                $_POST[$input->getPostVar()] = $input->getValue();
                if (!$input->checkInput()) {
                    $valid = false;
                }
            }
        }
        if (!$valid) {
            $this->setAlert(self::dic()->language()->txt("msg_input_is_required"));

            return false;
        }

        return $valid;
    }


    /**
     * @param string     $key
     * @param string     $value
     * @param bool|false $override
     *
     * @deprecated
     */
    public function addCustomAttribute(/*string*/ $key, /*string*/ $value, /*bool*/ $override = false)/*: void*/
    {
        if (isset($this->cust_attr[$key]) && !$override) {
            $this->cust_attr[$key] .= ' ' . $value;
        } else {
            $this->cust_attr[$key] = $value;
        }
    }


    /**
     * @return array
     *
     * @deprecated
     */
    public function getCustomAttributes()/*: array*/
    {
        return (array) $this->cust_attr;
    }


    /**
     * @param string            $iterator_id
     * @param ilFormPropertyGUI $input
     *
     * @return string
     *
     * @deprecated
     */
    protected function createInputPostVar(/*string*/ $iterator_id, ilFormPropertyGUI $input)/*: string*/
    {
        if ($this->getMulti()) {
            return $this->getPostVar() . '[' . $iterator_id . '][' . $input->getPostVar() . ']';
        } else {
            return $this->getPostVar() . '[' . $input->getPostVar() . ']';
        }
    }


    /**
     * Render item
     *
     * @param int  $iterator_id
     * @param bool $clean_render
     *
     * @return string
     * @throws ilException
     *
     * @deprecated
     */
    public function render(/*int*/ $iterator_id = 0, /*bool*/ $clean_render = false)/*: string*/
    {
        $first_label = true;
        $tpl = new Template(__DIR__ . "/templates/tpl.multi_line_input.html", true, true);
        $class = 'multi_input_line';
        $this->addCustomAttribute('class', $class, true);
        foreach ($this->getCustomAttributes() as $key => $value) {
            $tpl->setCurrentBlock('cust_attr');
            $tpl->setVariable('CUSTOM_ATTR_KEY', $key);
            $tpl->setVariable('CUSTOM_ATTR_VALUE', $value);
            $tpl->parseCurrentBlock();
        }
        $inputs = $this->inputs;
        $required = file_get_contents(__DIR__ . "/templates/tpl.multi_line_input_required.html");
        foreach ($inputs as $key => $input) {
            $input = clone $input;
            $is_hidden = false;
            $is_ta = false;
            if (!method_exists($input, 'render')) {
                switch (true) {
                    case ($input instanceof ilHiddenInputGUI):
                        $is_hidden = true;
                        break;
                    case ($input instanceof ilTextAreaInputGUI):
                        $is_ta = true;
                        break;
                    default:
                        throw new ilException("Method " . get_class($input)
                            . "::render() does not exists! You cannot use this input-type in ilMultiLineInputGUI");
                }
            }

            $is_disabled_hook = $this->getHook(self::HOOK_IS_INPUT_DISABLED);
            if ($is_disabled_hook !== false && !$clean_render) {
                $input->setDisabled($is_disabled_hook($this->getValue()));
            }
            if ($this->getDisabled()) {
                $input->setDisabled(true);
            }
            if ($iterator_id == 0 && !isset($this->post_var_cache[$key])) {
                $this->post_var_cache[$key] = $input->getPostVar();
            } else {
                // Reset post var
                $input->setPostVar($this->post_var_cache[$key]);
            }
            $post_var = $this->createInputPostVar($iterator_id, $input);
            $input->setPostVar($post_var);
            $before_render_hook = $this->getHook(self::HOOK_BEFORE_INPUT_RENDER);
            if ($before_render_hook !== false && !$clean_render) {
                $input = $before_render_hook($this->getValue(), $key, $input);
            }
            switch (true) {
                case $is_hidden:
                    $tpl->setCurrentBlock('hidden');
                    $tpl->setVariable('NAME', $post_var);
                    $tpl->setVariable('VALUE', ilUtil::prepareFormOutput($input->getValue()));
                    break;
                case $is_ta:
                    $input->insert($tpl);
                    if ($this->isShowLabel() || ($this->isShowLabelOnce() && $first_label)) {
                        $tpl->setCurrentBlock('input_label');
                        $tpl->setVariable('LABEL', $input->getTitle());
                        if ($input->getRequired()) {
                            $tpl->setVariable("REQUIRED", $required);
                        }
                        $tpl->setVariable('CONTENT', self::output()->getHTML($input));
                        $tpl->parseCurrentBlock();
                        $first_label = false;
                    } else {
                        $tpl->setCurrentBlock('input');
                        $tpl->setVariable('CONTENT', self::output()->getHTML($input));
                    }
                    break;
                default:
                    if ($this->isShowLabel() || ($this->isShowLabelOnce() && $first_label)) {
                        $tpl->setCurrentBlock('input_label');
                        $tpl->setVariable('LABEL', $input->getTitle());
                        if ($input->getRequired()) {
                            $tpl->setVariable("REQUIRED", $required);
                        }
                        $tpl->setVariable('CONTENT', self::output()->getHTML($input));
                        $first_label = false;
                    } else {
                        $tpl->setCurrentBlock('input');
                        $tpl->setVariable('CONTENT', self::output()->getHTML($input));
                    }
                    break;
            }
            if ($this->isShowInfo()) {
                if ($this->isShowLabel()) {
                    $tpl->setCurrentBlock('input_info_label');
                    $tpl->setVariable('INFO_LABEL', $input->getInfo());
                    $tpl->parseCurrentBlock();
                } else {
                    $tpl->setCurrentBlock('input_info');
                    $tpl->setVariable('INFO', $input->getInfo());
                    $tpl->parseCurrentBlock();
                }
            }
            $tpl->parseCurrentBlock();
        }
        if ($this->getMulti() && !$this->getDisabled()) {
            $image_plus = GlyphGUI::get('plus');
            $show_remove = true;
            $is_removeable_hook = $this->getHook(self::HOOK_IS_LINE_REMOVABLE);
            if ($is_removeable_hook !== false && !$clean_render) {
                $show_remove = $is_removeable_hook($this->getValue());
            }
            $show_remove = true;
            $image_minus = ($show_remove) ? GlyphGUI::get('minus') : '<span class="glyphicon glyphicon-minus hide"></span>';
            $tpl->setCurrentBlock('multi_icons');
            $tpl->setVariable('IMAGE_PLUS', $image_plus);
            $tpl->setVariable('IMAGE_MINUS', $image_minus);
            $tpl->parseCurrentBlock();
            if ($this->isPositionMovable()) {
                $tpl->setCurrentBlock('multi_icons_move');
                $tpl->setVariable('IMAGE_UP', GlyphGUI::get(GlyphGUI::UP));
                $tpl->setVariable('IMAGE_DOWN', GlyphGUI::get(GlyphGUI::DOWN));
                $tpl->parseCurrentBlock();
            }
        }

        return self::output()->getHTML($tpl);
    }


    /**
     * @deprecated
     */
    public function initCSSandJS()/*: void*/
    {
        $dir = __DIR__;
        $dir = "./" . substr($dir, strpos($dir, "/Customizing/") + 1);

        self::dic()->ui()->mainTemplate()->addCss($dir . '/css/multi_line_input.css');
        self::dic()->ui()->mainTemplate()->addJavascript($dir . '/js/multi_line_input.min.js');
    }


    /**
     * @param ilTemplate $tpl
     *
     * @deprecated
     */
    public function insert(ilTemplate $tpl) /*: void*/
    {
        $options = [
            // Services/Calendar/classes/class.ilCalendarUtil.php::addDateTimePicker
            "date_config" => [
                'locale'           => self::dic()->user()->getLanguage(),
                'stepping'         => 5,
                'useCurrent'       => false,
                'calendarWeeks'    => true,
                'toolbarPlacement' => 'top',
                //'showTodayButton' => true,
                'showClear'        => true,
                //'showClose' => true
                'keepInvalid'      => true,
                'sideBySide'       => true,
                //'collapse' => false,
                'format'           => !empty(self::dic()->user()->getId())
                && intval(self::dic()->user()->getId()) !== ANONYMOUS_USER_ID ? ilCalendarUtil::getUserDateFormat(false) : "DD.MM.YYYY"
            ]
        ];

        $output = "";

        $output .= $this->render(0, true);
        if ($this->getMulti() && is_array($this->line_values) && count($this->line_values) > 0) {
            foreach ($this->line_values as $run => $data) {
                $object = $this;
                $object->setValue($data);
                $output .= $object->render($run);
            }
        } else {
            $output .= $this->render(0, true);
        }
        if ($this->getMulti()) {
            $output = '<div id="' . $this->getFieldId() . '" class="multi_line_input">' . $output . '</div>';
            $output .= '<script type="text/javascript">$("#' . $this->getFieldId() . '").multi_line_input(' . json_encode($this->input_options) . ', '
                . json_encode($options) . ')</script>';
        }
        $tpl->setCurrentBlock("prop_generic");
        $tpl->setVariable("PROP_GENERIC", $output);
        $tpl->parseCurrentBlock();
    }


    /**
     * @inheritDoc
     *
     * @deprecated
     */
    public function getTableFilterHTML()/*: string*/
    {
        return $this->render();
    }


    /**
     * @inheritDoc
     *
     * @deprecated
     */
    public function getToolbarHTML()/*: string*/
    {
        return $this->render("toolbar");
    }


    /**
     * @return boolean
     *
     * @deprecated
     */
    public function isPositionMovable()/*: bool*/
    {
        return $this->position_movable;
    }


    /**
     * @param boolean $position_movable
     *
     * @deprecated
     */
    public function setPositionMovable(/*bool*/ $position_movable)/*: void*/
    {
        $this->position_movable = $position_movable;
    }


    /**
     * @return boolean
     *
     * @deprecated
     */
    public function isShowLabelOnce()/*: bool*/
    {
        return $this->show_label_once;
    }


    /**
     * @param boolean $show_label_once
     *
     * @deprecated
     */
    public function setShowLabelOnce(/*bool*/ $show_label_once)/*: void*/
    {
        $this->setShowLabel(false);
        $this->show_label_once = $show_label_once;
    }


    /**
     * @return boolean
     *
     * @deprecated
     */
    public function isShowInfo()/*: bool*/
    {
        return $this->show_info;
    }


    /**
     * @param boolean $show_info
     *
     * @deprecated
     */
    public function setShowInfo(/*bool*/ $show_info)/*: void*/
    {
        $this->show_info = $show_info;
    }
}
