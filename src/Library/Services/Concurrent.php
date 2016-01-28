<?php

/**
 * @author neeke@php.net
 * Date: 16/1/27 下午3:41
 */
class Services_Concurrent extends Services_BaseService
{
    /**
     * @var Services_Concurrent
     */
    static public $self = NULL;

    /**
     * @return Services_Concurrent
     */
    static public function instance()
    {
        if (is_null(self::$self)) {
            self::$self = new self();
        }

        SeasLog::setLogger(__CLASS__);

        return self::$self;
    }

    public function dataValid($api)
    {

    }

    public function transaction($api)
    {
        $result = Services_Concurrent_Transaction::instance();

        return $result;
    }
}