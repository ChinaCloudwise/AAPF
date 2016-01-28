<?php

/**
 * @author neeke@php.net
 *
 * 登录状态外，允许的router白名单
 * Class RouterWhitePlugin
 */
class RouterWhitePlugin extends Yaf_Plugin_Abstract
{
    /**
     * @var array
     * '路由'=>'请求方式'
     */
    private $router_white = array(
        'Index_Index_index' => 'get',
    );

    public function routerStartup(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response)
    {

    }

    private function check_router($request)
    {

        $router = $request->module . '_' . $request->controller . '_' . $request->action;

        if (array_key_exists($router, $this->router_white)) {
//            if (strtolower($_SERVER['REQUEST_METHOD']) == strtolower($this->router_white[$router])) {
//                return TRUE;
//            } else {
//                die('请采用' . $this->router_white[$router] . '请求方式');
//            }

            return TRUE;
        } else {
            return FALSE;
        }
    }

    public function routerShutdown(Yaf_Request_Abstract $request, Yaf_Response_Abstract $response)
    {
//        $if_in_router_white = $this->check_router($request);
//        if (!$if_in_router_white) {
//            die('404没有找到相应的资源!');
//        }
    }
}
