<?php

/**
 * @author neeke@php.net
 * Date: 16/1/27 上午10:56
 */
class ConcurrentController extends Scaffold
{
    public function init()
    {
        parent::init();
    }

    public function proxyAction()
    {
        $this->rest->method('POST');
        Services_Concurrent_SetVO::instance()->setApiProxy($this->params);


        $result = Services_Concurrent_Transaction::instance()->apiProxy();

        $this->rest->success($result);
    }

}