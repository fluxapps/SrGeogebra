<?php

namespace srag\DIC\SrGeogebra\DIC\Implementation;

use Collator;
use ilAccessHandler;
use ilAppEventHandler;
use ilAsqFactory;
use ilAuthSession;
use ilBenchmark;
use ilBookingManagerService;
use ilBrowser;
use ilComponentLogger;
use ilConditionService;
use ilCtrl;
use ilCtrlStructureReader;
use ilDBInterface;
use ilErrorHandling;
use ilExerciseFactory;
use ilGlobalTemplateInterface;
use ilHelpGUI;
use ILIAS;
use ILIAS\DI\BackgroundTaskServices;
use ILIAS\DI\Container;
use ILIAS\DI\HTTPServices;
use ILIAS\DI\LoggingServices;
use ILIAS\DI\UIServices;
use ILIAS\Filesystem\Filesystems;
use ILIAS\FileUpload\FileUpload;
use ILIAS\GlobalScreen\Services as GlobalScreenService;
use ILIAS\Refinery\Factory as RefineryFactory;
use ilIniFile;
use ilLanguage;
use ilLearningHistoryService;
use ilLocatorGUI;
use ilLoggerFactory;
use ilMailMimeSenderFactory;
use ilMailMimeTransportFactory;
use ilMainMenuGUI;
use ilNavigationHistory;
use ilNewsService;
use ilObjectDataCache;
use ilObjectDefinition;
use ilObjectService;
use ilObjUser;
use ilPluginAdmin;
use ilRbacAdmin;
use ilRbacReview;
use ilRbacSystem;
use ilSetting;
use ilStyleDefinition;
use ilTabsGUI;
use ilTaskService;
use ilToolbarGUI;
use ilTree;
use ilUIService;
use Session;
use srag\DIC\SrGeogebra\DIC\AbstractDIC;

/**
 * Class ILIAS60DIC
 *
 * @package srag\DIC\SrGeogebra\DIC\Implementation
 *
 * @author  studer + raimann ag - Team Custom 1 <support-custom1@studer-raimann.ch>
 */
final class ILIAS60DIC extends AbstractDIC
{

    /**
     * @inheritDoc
     */
    public function access() : ilAccessHandler
    {
        return $this->dic->access();
    }


    /**
     * @inheritDoc
     */
    public function appEventHandler() : ilAppEventHandler
    {
        return $this->dic->event();
    }


    /**
     * @inheritDoc
     */
    public function authSession() : ilAuthSession
    {
        return $this->dic["ilAuthSession"];
    }


    /**
     * @inheritDoc
     */
    public function backgroundTasks() : BackgroundTaskServices
    {
        return $this->dic->backgroundTasks();
    }


    /**
     * @inheritDoc
     */
    public function benchmark() : ilBenchmark
    {
        return $this->dic["ilBench"];
    }


    /**
     * @inheritDoc
     */
    public function bookingManager() : ilBookingManagerService
    {
        return $this->dic->bookingManager();
    }


    /**
     * @inheritDoc
     */
    public function browser() : ilBrowser
    {
        return $this->dic["ilBrowser"];
    }


    /**
     * @inheritDoc
     */
    public function clientIni() : ilIniFile
    {
        return $this->dic->clientIni();
    }


    /**
     * @inheritDoc
     */
    public function collator() : Collator
    {
        return $this->dic["ilCollator"];
    }


    /**
     * @inheritDoc
     */
    public function conditions() : ilConditionService
    {
        return $this->dic->conditions();
    }


    /**
     * @inheritDoc
     */
    public function ctrl() : ilCtrl
    {
        return $this->dic->ctrl();
    }


    /**
     * @inheritDoc
     */
    public function ctrlStructureReader() : ilCtrlStructureReader
    {
        return $this->dic["ilCtrlStructureReader"];
    }


    /**
     * @inheritDoc
     */
    public function databaseCore() : ilDBInterface
    {
        return $this->dic->database();
    }


    /**
     * @inheritDoc
     */
    public function error() : ilErrorHandling
    {
        return $this->dic["ilErr"];
    }


    /**
     * @inheritDoc
     */
    public function exercise() : ilExerciseFactory
    {
        return $this->dic->exercise();
    }


    /**
     * @inheritDoc
     */
    public function filesystem() : Filesystems
    {
        return $this->dic->filesystem();
    }


    /**
     * @inheritDoc
     */
    public function globalScreen() : GlobalScreenService
    {
        return $this->dic->globalScreen();
    }


    /**
     * @inheritDoc
     */
    public function help() : ilHelpGUI
    {
        return $this->dic->help();
    }


    /**
     * @inheritDoc
     */
    public function history() : ilNavigationHistory
    {
        return $this->dic["ilNavigationHistory"];
    }


    /**
     * @inheritDoc
     */
    public function http() : HTTPServices
    {
        return $this->dic->http();
    }


    /**
     * @inheritDoc
     */
    public function ilias() : ILIAS
    {
        return $this->dic["ilias"];
    }


    /**
     * @inheritDoc
     */
    public function iliasIni() : ilIniFile
    {
        return $this->dic->iliasIni();
    }


    /**
     * @inheritDoc
     */
    public function language() : ilLanguage
    {
        return $this->dic->language();
    }


    /**
     * @inheritDoc
     */
    public function learningHistory() : ilLearningHistoryService
    {
        return $this->dic->learningHistory();
    }


    /**
     * @inheritDoc
     */
    public function locator() : ilLocatorGUI
    {
        return $this->dic["ilLocator"];
    }


    /**
     * @inheritDoc
     */
    public function log() : ilComponentLogger
    {
        return $this->dic["ilLog"];
    }


    /**
     * @inheritDoc
     */
    public function logger() : LoggingServices
    {
        return $this->dic->logger();
    }


    /**
     * @inheritDoc
     */
    public function loggerFactory() : ilLoggerFactory
    {
        return $this->dic["ilLoggerFactory"];
    }


    /**
     * @inheritDoc
     */
    public function mailMimeSenderFactory() : ilMailMimeSenderFactory
    {
        return $this->dic["mail.mime.sender.factory"];
    }


    /**
     * @inheritDoc
     */
    public function mailMimeTransportFactory() : ilMailMimeTransportFactory
    {
        return $this->dic["mail.mime.transport.factory"];
    }


    /**
     * @inheritDoc
     */
    public function mainMenu() : ilMainMenuGUI
    {
        return $this->dic["ilMainMenu"];
    }


    /**
     * @inheritDoc
     *
     * @deprecated Please use `self::dic()->ui()->mainTemplate()`
     */
    public function mainTemplate() : ilGlobalTemplateInterface
    {
        return $this->dic->ui()->mainTemplate();
    }


    /**
     * @inheritDoc
     */
    public function news() : ilNewsService
    {
        return $this->dic->news();
    }


    /**
     * @inheritDoc
     */
    public function objDataCache() : ilObjectDataCache
    {
        return $this->dic["ilObjDataCache"];
    }


    /**
     * @inheritDoc
     */
    public function objDefinition() : ilObjectDefinition
    {
        return $this->dic["objDefinition"];
    }


    /**
     * @inheritDoc
     */
    public function object() : ilObjectService
    {
        return $this->dic->object();
    }


    /**
     * @inheritDoc
     */
    public function pluginAdmin() : ilPluginAdmin
    {
        return $this->dic["ilPluginAdmin"];
    }


    /**
     * @inheritDoc
     */
    public function question() : ilAsqFactory
    {
        return $this->dic->question();
    }


    /**
     * @inheritDoc
     */
    public function rbacadmin() : ilRbacAdmin
    {
        return $this->dic->rbac()->admin();
    }


    /**
     * @inheritDoc
     */
    public function rbacreview() : ilRbacReview
    {
        return $this->dic->rbac()->review();
    }


    /**
     * @inheritDoc
     */
    public function rbacsystem() : ilRbacSystem
    {
        return $this->dic->rbac()->system();
    }


    /**
     * @inheritDoc
     */
    public function refinery() : RefineryFactory
    {
        return $this->dic->refinery();
    }


    /**
     * @inheritDoc
     */
    public function session() : Session
    {
        return $this->dic["sess"];
    }


    /**
     * @inheritDoc
     */
    public function settings() : ilSetting
    {
        return $this->dic->settings();
    }


    /**
     * @inheritDoc
     */
    public function systemStyle() : ilStyleDefinition
    {
        return $this->dic->systemStyle();
    }


    /**
     * @inheritDoc
     */
    public function tabs() : ilTabsGUI
    {
        return $this->dic->tabs();
    }


    /**
     * @inheritDoc
     */
    public function task() : ilTaskService
    {
        return $this->dic->task();
    }


    /**
     * @inheritDoc
     */
    public function toolbar() : ilToolbarGUI
    {
        return $this->dic->toolbar();
    }


    /**
     * @inheritDoc
     */
    public function tree() : ilTree
    {
        return $this->dic->repositoryTree();
    }


    /**
     * @inheritDoc
     */
    public function ui() : UIServices
    {
        return $this->dic->ui();
    }


    /**
     * @inheritDoc
     */
    public function uiService() : ilUIService
    {
        return $this->dic->uiService();
    }


    /**
     * @inheritDoc
     */
    public function upload() : FileUpload
    {
        return $this->dic->upload();
    }


    /**
     * @inheritDoc
     */
    public function user() : ilObjUser
    {
        return $this->dic->user();
    }


    /**
     * @inheritDoc
     */
    public function &dic() : Container
    {
        return $this->dic;
    }
}
