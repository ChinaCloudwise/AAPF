<?php

/**
 * @author neeke@php.net
 * Date: 16/1/26 下午5:24
 */
class Services_Widget_SetVO
{
    /**
     * @var Services_Widget_SetVO
     */
    static public $self = NULL;

    /**
     * @return Services_Widget_SetVO
     */
    static public function instance()
    {
        if (is_null(self::$self)) {
            self::$self = new self();
        }

        return self::$self;
    }

    public function checkIfRPC($VO = NULL)
    {
        return strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'rpc') || (!is_null($VO) && $VO->rpc == TRUE);
    }

    /**
     * @var VO_Request_Widget_GetConfig
     */
    public $oRequestGetConfig;

    public function setRequestGetConfigVO(array $params)
    {
        return $this->oRequestGetConfig = VO_Bound::Bound($params, new VO_Request_Widget_GetConfig());
    }

}