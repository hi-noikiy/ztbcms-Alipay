<?php
namespace Alipay\Service;

require_once APP_PATH . 'Alipay/Sdk/aop/AopClient.php';
require_once APP_PATH . 'Alipay/Sdk/aop/SignData.php';
require_once APP_PATH . 'Alipay/Sdk/aop/request/ZhimaCreditScoreGetRequest.php';

/**
 * https://docs.open.alipay.com/api_8
 * Class Zmop
 * @package Alipay\Service
 */
class Zmop extends BaseService {

    static function getScore($userid){
        $transaction_id = date('YmdHis').rand(10000,99999);

        $alipay = M('Alipay')->where(['userid' => $userid])->find();
        if(!$alipay){
            return self::createReturn(false, null, '没有绑定支付帐号');
        }
        if($alipay['access_token_expires'] < time()){
            return self::createReturn(false, null, '请在支付宝客户端打开');
        }
        $access_token = $alipay['access_token'];

        //初始化
        $aop = self::getAopClient();

        $request = new \ZhimaCreditScoreGetRequest();
        $bizContent = [
            "transaction_id" => $transaction_id,
            "product_code" => 'w1010100100000000001'
        ];

        $request->setBizContent(json_encode($bizContent));

        $result= $aop->execute($request, $access_token);

        $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
        $resultCode = $result->$responseNode->code;

        $data = json_decode( json_encode( $result->$responseNode),true);
        if(!empty($resultCode)&&$resultCode == 10000){
            //芝麻分 $data['data']['zm_score']
            return self::createReturn(true, $data, '获取成功');
        } else {
            $error = $result->$responseNode->sub_msg;
            return self::createReturn(false, $data, $error?$error:'获取失败');
        }
    }

}