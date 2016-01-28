<?php

/**
 * Class Bootstrap
 *
 * @author neeke@php.net
 */
class Bootstrap extends Yaf_Bootstrap_Abstract
{
    public function _initSession($dispatcher)
    {
//        Yaf_Session::getInstance()->start();
    }

    public function _initConfig()
    {
        $config = Yaf_Application::app()->getConfig();
        Yaf_Registry::set("config", $config);
    }

    /**
     * @param Yaf_Dispatcher $dispatcher
     */
    public function _initDefaultName(Yaf_Dispatcher $dispatcher)
    {
        $dispatcher->setDefaultModule("Index")->setDefaultController("Index")->setDefaultAction("index");
    }

    /**
     * @param Yaf_Dispatcher $dispatcher
     */
    public function _initRouterWhite(Yaf_Dispatcher $dispatcher)
    {
        $dispatcher->registerPlugin(new RouterWhitePlugin());
    }

    /**
     * @param Yaf_Dispatcher $dispatcher
     */
    public function _initTemplate(Yaf_Dispatcher $dispatcher)
    {
        $dispatcher->autoRender(FALSE);
    }

}
