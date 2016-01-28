<?php

/**
 * @author neeke@php.net
 * Date: 16/1/27 下午3:05
 */
class Services_Concurrent_Transaction
{
    static public $self = NULL;

    /**
     * @var null|REST_Client
     */
    public $restClient = NULL;

    /**
     * @return null|Services_Concurrent_Transaction
     */
    static public function instance()
    {
        if (is_null(self::$self)) {
            self::$self = new self();
        }

        return self::$self;
    }

    /**
     * @var Services_Concurrent_SetVO
     */
    private $oSetVO;

    public function __construct()
    {
        $this->oSetVO = Services_Concurrent_SetVO::instance();

        $this->restClient = REST_Client::instance();
    }

    /**
     * @var VO_Request_Concurrent_ProxyEntity
     */
    private $oRequestEntity;

    /**
     * @var
     */
    static private $responseResult = array();

    public function apiProxy()
    {
        if (!is_array($this->oSetVO->oProxyRequest->data)) {
            throw new Exception('Request is not a array.');
        }

        $haveYar = FALSE;

        foreach ($this->oSetVO->oProxyRequest->data as $id => $this->oRequestEntity) {
            switch ($this->oRequestEntity->method) {
                case Constants_ConcurrentEnum::METHOD_REST_GET:
                case Constants_ConcurrentEnum::METHOD_REST_POST:

                    $this->restClient->setApi($this->oRequestEntity->api);
                    $this->restClient->setMethod($this->oRequestEntity->method);
                    $this->restClient->setData($this->oRequestEntity->params);
                    $this->restClient->go();
                    $tmp = $this->restClient->getBody();

                    self::$responseResult[$this->oRequestEntity->identifier] = $tmp;

                    break;

                case Constants_ConcurrentEnum::METHOD_RPC_YAR:
                    $haveYar                      = TRUE;
                    $params                       = array(
                        'identifier' => $this->oRequestEntity->identifier,
                    );
                    $this->oRequestEntity->params = array(array_merge($params, $this->oRequestEntity->params));

                    Yar_Concurrent_Client::call($this->oRequestEntity->api, $this->oRequestEntity->function, $this->oRequestEntity->params, "Services_Concurrent_Transaction::callBack");

                    break;
            }

        }

        if ($haveYar) {
            Yar_Concurrent_Client::loop("Services_Concurrent_Transaction::callBack", "Services_Concurrent_Transaction::errorCallBack");
        }

        return self::$responseResult;
    }

    static public function callBack($retval, $callinfo)
    {
        if (!is_null($retval) && array_key_exists('identifier', $retval)) {
            self::$responseResult[$retval['identifier']] = $retval['data'];
        }
    }

    static public function errorCallBack($type, $error, $callinfo)
    {
        SeasLog::error(json_encode(array($type, $error, $callinfo)));
    }

}