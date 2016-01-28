<?php

/**
 * @author neeke@php.net
 * Date: 16/1/26 下午5:24
 */
class Services_Widget_ValidVO
{
    /**
     * @var Services_Widget_ValidVO
     */
    static public $self = NULL;

    /**
     * @return Services_Widget_ValidVO
     */
    static public function instance()
    {
        if (is_null(self::$self)) {
            self::$self = new self();
        }

        return self::$self;
    }

    /**
     * @var Services_Widget_SetVO
     */
    private $oSetVO;

    public function __construct()
    {
        $this->oSetVO = Services_Widget_SetVO::instance();
    }

    public function validGetConfig()
    {

    }
}