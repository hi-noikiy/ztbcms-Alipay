<?php
namespace Alipay\Service;

require_once APP_PATH . 'Alipay/Sdk/aop/request/AlipaySystemOauthTokenRequest.php';
require_once APP_PATH . 'Alipay/Sdk/aop/request/AlipayUserUserinfoShareRequest.php';

/**
 * Class AuthService
 * @package Alipay\Service
 */
class AuthService extends BaseService {

    /**
     * 获取授权用户信息
     * @param $auth_code
     * @return mixed
     */
    static function getUserInfo($auth_code) {

        $aop = self::getAopClient();
        //获取access_token
        $request = new \AlipaySystemOauthTokenRequest();
        $request->setGrantType("authorization_code");
        $request->setCode($auth_code);//这里传入 code
        $result = $aop->execute($request);
        $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
        $access_token = $result->$responseNode->access_token;
        $expires_in = $result->$responseNode->expires_in;

        //获取用户信息
        $request_a = new \AlipayUserUserinfoShareRequest();
        $result_a = $aop->execute ($request_a,$access_token); //这里传入获取的access_token
        $responseNode_a = str_replace(".", "_", $request_a->getApiMethodName()) . "_response";

        $data = json_decode( json_encode( $result_a->$responseNode_a),true);
        unset($data['user_id']); //官方文档:user_id已废弃

        $data['access_token'] = $access_token;
        $data['access_token_expires'] = time() + $expires_in; //access_token有效期

        return $data;
    }
}