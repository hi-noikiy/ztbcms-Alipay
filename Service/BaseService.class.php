<?php
namespace Alipay\Service;

require_once APP_PATH . 'Alipay/Sdk/aop/AopClient.php';
require_once APP_PATH . 'Alipay/Sdk/aop/SignData.php';

class BaseService {

    /**
     * APPID
     * @return mixed
     */
    static function getAppId(){
        return D('Config')->where(['varname' => 'alipay_app_id'])->find()['value'];
    }

    /**
     * 私钥
     * @return mixed
     */
    static function getRsaPrivateKey(){
        return D('Config')->where(['varname' => 'alipay_private_key'])->find()['value'];
    }

    /**
     * 公钥
     * @return mixed
     */
    static function getAlipayrsaPublicKey(){
        return D('Config')->where(['varname' => 'alipay_public_key'])->find()['value'];
    }

    /**
     * 签名方式
     * @return mixed
     */
    static function getSignType(){
        return D('Config')->where(['varname' => 'sign_type'])->find()['value'];
    }

    /**
     * 初始化
     */
    static function getAopClient($gatewayUrl = 'https://openapi.alipay.com/gateway.do'){

        $appid = self::getAppId();
        $rsaPrivateKey = self::getRsaPrivateKey();
        $alipayrsaPublicKey = self::getAlipayrsaPublicKey();
        $sign_type = self::getSignType();

        //初始化
        $aop = new \AopClient();
        $aop->gatewayUrl = $gatewayUrl;
        $aop->appId = $appid;
        $aop->rsaPrivateKey = $rsaPrivateKey;
        $aop->alipayrsaPublicKey = $alipayrsaPublicKey;
        $aop->apiVersion = '1.0';
        $aop->signType = $sign_type;
        $aop->postCharset='UTF-8';
        $aop->format='json';

        return $aop;
    }

    /**
     * 创建统一的Service返回结果
     *
     * @param boolean $status
     * @param array   $data
     * @param string  $msg
     * @return array
     */
    protected static function createReturn($status, $data = [], $msg = '') {
        return [
            'status' => $status,
            'data' => $data,
            'msg' => $msg
        ];
    }
}