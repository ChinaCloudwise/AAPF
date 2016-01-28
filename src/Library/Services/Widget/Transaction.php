<?php

/**
 * @author neeke@php.net
 * Date: 15-10-29 上午10:53
 */
class Services_Widget_Transaction
{
    static public $self = NULL;

    /**
     * @var null|REST_Client
     */
    public $client = NULL;

    /**
     * @return null|Services_Widget_Transaction
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

        $this->client = REST_Client::instance();
    }

    /**
     * @param null $param1
     * @param null $param2
     *
     * @return int
     */
    public function GetConfig($param1 = NULL, $param2 = NULL)
    {
        return 1;
    }

    /**
     * 数字相加
     *
     * @param $params
     *
     * @return array|number
     */
    public function Add($params = NULL)
    {
        if (!array_key_exists('identifier', $params)) {
            return array_sum($params);
        }

        return array(
            'identifier' => $params['identifier'],
            'data'       => array_sum($params),
        );
    }

    /**
     * 数字相减
     *
     * @param null $params
     *
     * @return array
     */
    public function Sub($params = NULL)
    {
        if (!array_key_exists('identifier', $params)) {
            return array_sum($params);
        }

        return array(
            'identifier' => $params['identifier'],
            'data'       => $params['p1'] - $params['p2'],
        );
    }

}