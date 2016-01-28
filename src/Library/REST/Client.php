<?php

/**
 * RestClient
 *
 * @author neeke@php.net
 *
 * demo
 *        $data = array(
 *            'param1' => 'test',
 *            'param2' => 'test',
 *            );
 *
 *        $this->c = REST_Client::instance();
 *        $this->c->setMethod('POST');
 *        $this->c->setData($data);
 *        $this->c->setApi('http://example.com/api/test');
 *        $this->c->go();
 *        $body = $this->c->getBody();
 *        var_dump($body);
 */
class REST_Client
{

    /**
     * @var REST_Client
     */
    private static $self = NULL;

    /**
     * @static
     * @return REST_Client
     */
    public static function instance()
    {
        if (self::$self == NULL) {
            self::$self = new self;
        }

        return self::$self;
    }

    /**
     * method方法
     *
     * @var (string)GET|POST|PUT|DELETE
     */
    private $method = 'get';

    public function setMethod($method)
    {
        $this->method = strtolower($method);
    }

    /**
     * api url
     *
     * @var (string)url
     */
    private $api = NULL;

    /**
     * @param $api
     */
    public function setApi($api)
    {
        $this->api = $api;
    }

    /**
     * GET或POST的请求参数
     *
     * @var (array)请求参数
     */
    private $data   = array();
    private $ifData = FALSE;

    public function setData($data)
    {
        $this->ifData = TRUE;
        $this->data   = $data;
    }

    /**
     * 设置referer来源
     *
     * @var (string)referer
     */
    private $referer   = NULL;
    private $ifReferer = FALSE;

    public function setReferer($referer)
    {
        $this->ifReferer = TRUE;
        $this->referer   = $referer;
    }

    /**
     * 设置请求header头
     *
     * @var array
     */
    private $reqHeader = array('Accept-Language: zh-cn', 'Connection: Keep-Alive', 'Cache-Control: no-cache');

    public function setHeader($header)
    {
        if (!is_null($header) && !empty($header)) {
            if (is_array($header)) {
                $this->reqHeader = array_merge($this->reqHeader, $header);
            } elseif (is_string($header)) {
                array_push($this->reqHeader, $header);
            }
        }
    }

    private $repHeader = NULL;

    /**
     * @return null
     */
    public function getHeader()
    {
        return $this->repHeader;
    }

    private $body = NULL;

    /**
     * @return null
     */
    public function getBody()
    {
        return $this->body;
    }

    /**
     * 走起
     */
    public function go()
    {
        self::valid();
        self::myCurl();
    }

    private function valid()
    {
        if ($this->api == NULL) {
            throw new Exception('$this->api can not be null');
        }

        if ($this->ifData && (!is_array($this->data) || count($this->data) < 1)) {
            throw new Exception('$this->data is empty');
        }

        if ($this->ifReferer && (strlen($this->referer) < 1)) {
            throw new Exception('$this->referer is empty');
        }

        if ($this->method != 'get' && !in_array($this->method, array('post', 'put', 'delete'))) {
            throw new Exception('$this->method is error');
        }
    }

    private function myCurl()
    {
        $ch        = curl_init();
        $timeout   = 300;
        $useragent = "Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)";
        curl_setopt($ch, CURLOPT_HTTPHEADER, $this->reqHeader);
        curl_setopt($ch, CURLOPT_USERAGENT, $useragent);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        switch ($this->method) {
            case 'get':
                $api = $this->api . '?';
                foreach ($this->data as $k => $v) {
                    $api .= $k . '=' . $v . '&';
                }
                curl_setopt($ch, CURLOPT_URL, $api);
                break;
            case 'post':
                curl_setopt($ch, CURLOPT_URL, $this->api);
                curl_setopt($ch, CURLOPT_POST, TRUE);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $this->data);
                break;
            case 'put':
                curl_setopt($ch, CURLOPT_PUT, TRUE);
                break;
            case 'delete':
                curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'DELETE');
                break;
        }

        if ($this->ifReferer) {
            curl_setopt($ch, CURLOPT_REFERER, $this->referer);
        }

        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);

        if (curl_errno($ch)) {
            throw new Exception('CURL was error');
        } else {
            $this->body      = curl_exec($ch);
            $this->repHeader = curl_getinfo($ch);
        }

        curl_close($ch);
    }

}