<?php

namespace srag\CustomInputGUIs\SrGeogebra\UIInputComponentWrapperInputGUI;

use ilFormException;
use ilFormPropertyGUI;
use ILIAS\UI\Component\Input\Field\Input;
use ILIAS\UI\Implementation\Component\Input\Container\Form\PostDataFromServerRequest;
use ilTableFilterItem;
use ilTemplate;
use ilToolbarItem;
use srag\CustomInputGUIs\SrGeogebra\Template\Template;
use srag\DIC\SrGeogebra\DICTrait;
use Throwable;

/**
 * Class UIInputComponentWrapperInputGUI
 *
 * @package srag\CustomInputGUIs\SrGeogebra\UIInputComponentWrapperInputGUI
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
class UIInputComponentWrapperInputGUI extends ilFormPropertyGUI implements ilTableFilterItem, ilToolbarItem
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

            self::dic()->ui()->mainTemplate()->addCss($dir . "/css/UIInputComponentWrapperInputGUI.css");
        }
    }


    /**
     * @var Input
     */
    protected $input;


    /**
     * UIInputComponentWrapperInputGUI constructor
     *
     * @param Input  $input
     * @param string $post_var
     */
    public function __construct(Input $input, string $post_var = "")
    {
        $this->input = $input;

        $this->setPostVar($post_var);

        //parent::__construct($title, $post_var);

        self::init();
    }


    /**
     * @inheritDoc
     */
    public function checkInput() : bool
    {
        try {
            $this->input = $this->input->withInput(new PostDataFromServerRequest(self::dic()->http()->request()));

            return (!$this->input->getContent()->isError());
        } catch (Throwable $ex) {
            return false;
        }
    }


    /**
     * @inheritDoc
     */
    public function getAlert()/*:string*/
    {
        return $this->input->getError();
    }


    /**
     * @inheritDoc
     *
     * @throws ilFormException
     */
    public function getDisabled()/*:bool*/
    {
        if (self::version()->is60()) {
            return $this->input->getDisabled();
        } else {
            throw new ilFormException("disabled not exists in ILIAS 5.4 or below!");
        }
    }


    /**
     * @inheritDoc
     */
    public function getInfo()/*:string*/
    {
        return $this->input->getByline();
    }


    /**
     * @return Input
     */
    public function getInput() : Input
    {
        return $this->input;
    }


    /**
     * @inheritDoc
     */
    public function getPostVar()/*:string*/
    {
        return $this->input->getName();
    }


    /**
     * @inheritDoc
     */
    public function getRequired()/*:bool*/
    {
        return $this->input->isRequired();
    }


    /**
     * @inheritDoc
     */
    public function getTableFilterHTML() : string
    {
        return $this->render();
    }


    /**
     * @inheritDoc
     */
    public function getTitle()/*:string*/
    {
        return $this->input->getLabel();
    }


    /**
     * @inheritDoc
     */
    public function getToolbarHTML() : string
    {
        return $this->render();
    }


    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->input->getValue();
    }


    /**
     * @param ilTemplate $tpl
     */
    public function insert(ilTemplate $tpl) /*: void*/
    {
        $html = $this->render();

        $tpl->setCurrentBlock("prop_generic");
        $tpl->setVariable("PROP_GENERIC", $html);
        $tpl->parseCurrentBlock();
    }


    /**
     * @return string
     */
    public function render() : string
    {
        $tpl = new Template(__DIR__ . "/templates/input.html");

        $tpl->setVariable("INPUT", self::output()->getHTML($this->input));

        return self::output()->getHTML($tpl);
    }


    /**
     * @inheritDoc
     */
    public function setAlert(/*string*/ $error)/*: void*/
    {
        $this->input = $this->input->withError($error);
    }


    /**
     * @inheritDoc
     *
     * @throws ilFormException
     */
    public function setDisabled(/*bool*/ $disabled)/*: void*/
    {
        if (self::version()->is60()) {
            $this->input = $this->input->withDisabled($disabled);
        } else {
            throw new ilFormException("disabled not exists in ILIAS 5.4 or below!");
        }
    }


    /**
     * @inheritDoc
     */
    public function setInfo(/*string*/ $info)/*: void*/
    {
        $this->input = $this->input->withByline($info);
    }


    /**
     * @param Input $input
     */
    public function setInput(Input $input)/*: void*/
    {
        $this->input = $input;
    }


    /**
     * @inheritDoc
     */
    public function setPostVar(/*string*/ $post_var)/*: void*/
    {
        $this->input = $this->input->withNameFrom(new UIInputComponentWrapperNameSource($post_var));
    }


    /**
     * @inheritDoc
     */
    public function setRequired(/*bool*/ $required)/*: void*/
    {
        $this->input = $this->input->withRequired($required);
    }


    /**
     * @inheritDoc
     */
    public function setTitle(/*string*/ $title)/*: void*/
    {
        $this->input = $this->input->withLabel($title);
    }


    /**
     * @param mixed $value
     */
    public function setValue($value)/*: void*/
    {
        $this->input = $this->input->withValue($value);
    }


    /**
     * @param array $values
     */
    public function setValueByArray(/*array*/ $values)/*: void*/
    {
        if (isset($values[$this->getPostVar()])) {
            $this->setValue($values[$this->getPostVar()]);
        }
    }
}
