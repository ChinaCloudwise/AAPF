<?php

/**
 * 连接数据库
 *
 * @author neeke@php.net
 *
 */
class DB_Connect
{
    /**
     * @param string $which
     *
     * @return DB_Mysql
     */
    static public function db($which = 'master')
    {

        $DB_config    = Yaf_Registry::get('config')->get('yaf')->get('db')->$which;
        $cache_config = Yaf_Registry::get('config')->get('yaf')->get('cache');

        $db = DB_Mysql::getInstance($DB_config, $cache_config);

        return $db;
//		return ($db instanceof DB_DbInterface) ? $db : false;

    }

}
