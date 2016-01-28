<?php

/**
 * Scaffold Controller base
 *
 * @author neeke@php.net
 *
 */
class Scaffold extends Yaf_Controller_Abstract
{
    protected $table_name = '';
    protected $primary    = '';
    protected $columns    = array();
    protected $Scaffold   = FALSE;

    /**
     * @var Models
     */
    public $model;
    /**
     * @var DB_Mysql
     */
    public $db;
    public $meta;

    protected $appconfig = array();
    protected $userinfo  = array();
    protected $user_id   = 0;

    /**
     * @var REST_Server
     */
    protected $rest;

    /**
     * @var REST_Client
     */
    protected $client;
    /**
     * @var REST_Check
     */
    protected $check;

    /**
     * @var REST_Quantity
     */
    protected $quantity;

    /**
     * @var REST_Modified
     */
    protected $modified;

    /**
     * @var Yaf_Session
     */
    protected $session;

    /**
     * @var REST_Mkdata
     */
    protected $mkData;

    /**
     * 用户所有提交信息
     */
    public $params;


    /**
     * @var
     */
    protected $allParams = array();

    protected $start = 0;
    protected $limit = 0;

    protected $scaffoldC = FALSE;

    public function init()
    {
        $validator = new BaseValid();
        $validator->executeFilterMethod($this->getRequest());

        $this->check  = REST_Check::instance();
        $this->rest   = REST_Server::instance();
        $this->client = REST_Client::instance();
        $this->params = array_merge($_POST, $_GET);
        //$this->db       = DB_Contect::db();
        //$this->quantity = REST_Quantity::instance();
        //$this->modified = REST_Modified::instance();
        // $this->session  = Yaf_Session::getInstance();
        // $this->mkData   = REST_Mkdata::instance();

        //  $this->setScaffoldConfig();
        //  $this->ScaffoldRoute();
        //$this->setConfig();

    }

    /**
     * 取得所有参数
     *
     * @return mixed
     */
    protected function allParams()
    {
        $params = $this->getRequest()->getParams();
        $params += $_GET;
        $params += $_POST;
        $this->allParams = $params;

        return $params;
    }

    /**
     * 取得start limit值
     */
    protected function getStartLimit()
    {
        if (count($this->allParams) < 1) {
            $this->allParams();
        }

        $this->start = array_key_exists('start', $this->allParams) ? (int)$this->allParams['start'] : 0;
        $this->limit = array_key_exists('limit', $this->allParams) ? (int)$this->allParams['limit'] : 10;
    }


    /**
     * 设置变量到模板
     *
     * @param        $key
     * @param string $val
     */
    protected function set($key, $val = '')
    {
        $this->getView()->assign($key, $val);
    }

    /**
     * 获取模板变量
     *
     * @param $key
     *
     * @return mixed
     */
    protected function get($key)
    {
        return $this->getView()->get($key);
    }

    /**
     * 设置页面config值
     *
     * @param $config
     */
    protected function setConfig($config = array())
    {
        $config_    = array_merge($config, $this->userinfo);
        $config_get = $this->get('config');
        if ($config_get) {
            $config_set = array_merge($config_get, $config_);
        } else {
            $config_set = $config_;
        }

        $this->set('config', $config_set);
    }

    public function __destruct()
    {
        if ($this->db) {
            $this->db->close();
        }
    }
}