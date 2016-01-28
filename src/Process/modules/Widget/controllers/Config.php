<?php

/**
 * @author neeke@php.net
 * Date: 16/1/26 下午3:48
 */
class ConfigController extends Scaffold
{
    public function init()
    {
        parent::init();
    }

    public function getConfigAction()
    {

        $requestVO = Services_Widget_SetVO::instance()->setRequestGetConfigVO($this->params);

        if (Services_Widget_SetVO::instance()->checkIfRPC($requestVO)) {

            $service1 = new Yar_Server(new Services_Widget_Transaction());
            $service1->handle();
        } else {
            var_dump(__CLASS__, __FUNCTION__);
        }
    }
}