<?php

/**
 * Class Services_BaseValid
 *
 * @author neeke@php.net
 */
class Services_BaseValid
{
    public function validAppId($app_id)
    {
        return isset(Constants_CommonEnum::$passport['account'][$app_id]);
    }

    public function validSign($params)
    {
        $sign = Helper_AccountToken::generateSign(json_encode($params));

        return $sign == $params->sign;
    }

    public function validTimestamp($timestamp)
    {
        return strlen(intval($timestamp)) == 10;
    }
}