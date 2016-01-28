<?php

/**
 * 单例cache
 *
 * @author neeke@php.net
 *
 */
class DB_Cache
{

    private $cache  = NULL;
    private $driver = 'memcache';
    public  $debug  = FALSE;

    /**
     * @var DB_Cache
     */
    private static $self = NULL;

    /**
     * @static
     *
     * @param int    $cachehost
     * @param int    $cacheport
     * @param string $cacheType
     * @param string $cacheSys
     *
     * @return DB_Cache
     */
    public static function instance($cachehost = 0, $cacheport = 0, $cacheType = 'memcached', $cacheSys = '')
    {
        if (self::$self == NULL) {
            $cache_config  = Yaf_Registry::get('config')->get('yaf')->get('cache');
            $_cache_system = $cache_config->system;
            $_cache_type   = $cache_config->type;
            $_cache_host   = $cache_config->host;
            $_cache_port   = $cache_config->port;

            self::$self = new DB_Cache($_cache_system, $_cache_type, $_cache_host, $_cache_port);
        }

        return self::$self;
    }

    public function __construct($cacheSys, $cacheType, $cachehost, $cacheport)
    {
        $this->driver = $cacheType;
        switch ($this->driver) {
            case 'memcached':

                $this->cache = new Memcache();
                $connect     = $this->cache->connect($cachehost, $cacheport);

                break;
            case 'redis':
                $this->cache = new Redis();
                $connect     = $this->cache->connect($cachehost, $cacheport);
                break;
            default:
                ;
        }

        if ($connect == FALSE) {
            echo '<pre><b>' . $this->driver . ' Connection failed.  please check the *.ini cache</b></pre>';
            die;
        }
    }

    /**
     * 设置cahce
     *
     * @param string            $key
     * @param string|array|bool $value
     * @param int|string        $lifetime
     *
     * @return bool
     */
    public function set($key, $value, $lifetime = '60')
    {

        if ($value === FALSE) return FALSE;
        if ($this->debug) var_dump('cache set: ' . $key, $value);


        if ($this->driver == 'memcache') {
            return $this->cache->set($key, $value, FALSE, $lifetime);

        } elseif ($this->driver == 'redis') {
            $value = is_numeric($value) ? $value : serialize($value);
            $this->cache->set($key, $value, $lifetime);

            return TRUE;


        }

        return FALSE;
    }

    /**
     * 获取cache
     *
     * @param string $Key
     *
     * @return string|array|bool
     */
    public function get($Key)
    {
        $value = $this->cache->get($Key);
        if ($this->driver == 'memcache') {
            return $value;
        } elseif ($this->driver == 'redis') {
            return is_numeric($value) ? $value : unserialize($value);
        }

        return FALSE;
    }

    /**
     * 关闭cache连接
     */
    public function close()
    {
        $this->cache->close();
    }
}
