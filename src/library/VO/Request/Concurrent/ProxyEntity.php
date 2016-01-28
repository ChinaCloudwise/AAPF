<?php

/**
 * @author neeke@php.net
 * Date: 16/1/27 下午12:25
 */
class VO_Request_Concurrent_ProxyEntity extends VO_Request_Concurrent_CommonVO
{
    public $api;

    public $params = array();

    public $identifier;

    public $method;//enum  get post put delete yar

    public $function;
}