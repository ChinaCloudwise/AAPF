<?php

/**
 * @author neeke@php.net
 * Date: 16/1/26 下午5:33
 */
class Services_Widget extends Services_BaseService
{
    static public $self = NULL;

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
        switch ($api) {
            case Constants_WidgetConfigEnum::GET_CONFIG:
                Services_Widget_ValidVO::instance()->validGetConfig();
                break;
        }
    }

    public function transaction($api)
    {
        switch ($api) {
            case Constants_WidgetConfigEnum::GET_CONFIG:
                $result = Services_Widget_Transaction::instance()->GetConfig();
                break;
        }

        return $result;
    }
}