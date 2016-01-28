<?php

/**
 * @author neeke@php.net
 * Date: 16/1/27 下午3:05
 */
class Services_Concurrent_SetVO
{
    /**
     * @var Services_Concurrent_SetVO
     */
    static public $self = NULL;

    /**
     * @return Services_Concurrent_SetVO
     */
    static public function instance()
    {
        if (is_null(self::$self)) {
            self::$self = new self();
        }

        return self::$self;
    }

    /**
     * @var VO_Request_Concurrent_Proxy
     */
    public $oProxyRequest;

    /**
     * @var VO_Request_Concurrent_ProxyEntity
     */
    public $oProxyEntityTmp;

    /**
     * @param array $params
     *
     * @return VO_Common|VO_Request_Concurrent_Proxy
     */
    public function setApiProxy(array $params)
    {

        $this->oProxyRequest = VO_Bound::Bound($params, new VO_Request_Concurrent_Proxy());

        $data = array();

        foreach ($this->oProxyRequest->data as $v) {
            $this->oProxyEntityTmp                    = VO_Bound::Bound($v, new VO_Request_Concurrent_ProxyEntity());
            $data[$this->oProxyEntityTmp->identifier] = $this->oProxyEntityTmp;
        }

        $this->oProxyRequest->data = $data;
        unset($data);

        return $this->oProxyRequest;
    }


}