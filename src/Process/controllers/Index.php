<?php

/**
 * @author neeke@php.net
 * Date: 16/1/26 上午11:29
 */
class IndexController extends Scaffold
{
    public function indexAction()
    {
        $result = array(
            __CLASS__,
            __FUNCTION__,
        );
        $this->rest->success($result);
    }
}