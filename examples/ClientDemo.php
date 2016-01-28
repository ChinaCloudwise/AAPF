<?php
/**
 * @author neeke@php.net
 * Date: 16/1/28 下午3:41
 */
error_reporting(1);

$request = array(
    'data' => array(
        array(
            'api'        => 'http://dev.aapfdemo.com/widget/config/getconfig',
            'params'     => array(
                'p1' => 10,
                'p2' => 20,
            ),
            'method'     => 'yar',
            'function'   => 'add',
            'identifier' => 'add_result',
        ),

        array(
            'api'        => 'http://dev.aapfdemo.com/widget/config/getconfig',
            'params'     => array(
                'p1' => 20,
                'p2' => 5,
            ),
            'method'     => 'yar',
            'function'   => 'sub',
            'identifier' => 'sub_result',
        ),
        array(
            'api'        => 'http://int.dpool.sina.com.cn/iplookup/iplookup.php',
            'params'     => array(
                'format' => 'json',
            ),
            'method'     => 'get',
            'identifier' => 'ip_result',
        ),
    ),
);

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, 'http://dev.aapfdemo.com/concurrent/proxy');
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POST, TRUE);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($request));


if (curl_errno($ch)) {
    throw new Exception('CURL was error');
} else {
    $repBody   = curl_exec($ch);
    $repHeader = curl_getinfo($ch);
}

curl_close($ch);

print_r(json_decode($repBody, TRUE));