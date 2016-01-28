<?php

/**
 * interface of all services
 *
 * @author neeke@php.net
 */
interface Services_ServiceInterface
{
    /**
     * service 应明确为单例
     *
     * @return mixed
     */
    static public function instance();

    /**
     * @param $api
     * data valid for job
     *
     * @return mixed
     */
    public function dataValid($api);

    /**
     * @param $api
     * transaction for job
     *
     * @return mixed
     */
    public function transaction($api);
}