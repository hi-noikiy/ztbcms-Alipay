<?php
namespace Alipay\Service;

use System\Service\OrderService;

require_once APP_PATH . 'Alipay/Sdk/aop/AopClient.php';
require_once APP_PATH . 'Alipay/Sdk/aop/SignData.php';
require_once APP_PATH . 'Alipay/Sdk/aop/request/AlipayTradeRefundRequest.php';

class AlipayPay extends BaseService {

    /**
     * 更新支付订单的信息
     *
     * @param $data
     */
    static function updateOrderInfo($data) {
        $is_exist = M('AlipayPayOrder')->where(['out_trade_no' => $data['out_trade_no']])->find();
        if ($is_exist) {
            //如果存在
            M('AlipayPayOrder')->where(['id' => $is_exist['id']])->save($data);
        } else {
            M('AlipayPayOrder')->add($data);
        }
    }


    /**
     * 退款
     * 可多次
     * @param $order_id
     * @param $return_money
     * @return array
     */
    static function returnMoney($order_id, $return_money){

        $order = OrderService::getOrderById($order_id)['data'];
        $alipayOrder = M('AlipayPayOrder')->where(['out_trade_no' => $order['order_sn']])->find();

        $appid = $alipayOrder['app_id'];
        $rsaPrivateKey = self::getRsaPrivateKey();
        $alipayrsaPublicKey = self::getAlipayrsaPublicKey();
        $signType = self::getSignType();
        $version = $alipayOrder['version'];

        $aop = new \AopClient();
        $aop->gatewayUrl = 'https://openapi.alipay.com/gateway.do';
        $aop->appId = $appid;
        $aop->rsaPrivateKey = $rsaPrivateKey;
        $aop->alipayrsaPublicKey = $alipayrsaPublicKey;
        $aop->apiVersion = $version;
        $aop->signType = $signType;
        $aop->postCharset='UTF-8';
        $aop->format='json';
        $request = new \AlipayTradeRefundRequest();

        $out_trade_no = $order['order_sn'];
        $refund_amount = $return_money;
        $out_request_no = $out_trade_no.rand(1000,9999);

        $bizContent = [
            "out_trade_no" => $out_trade_no,
            "refund_amount" => $refund_amount,
            "out_request_no" => $out_request_no
        ];

        $request->setBizContent(json_encode($bizContent));
        $result = $aop->execute($request);

        $responseNode = str_replace(".", "_", $request->getApiMethodName()) . "_response";
        $resultCode = $result->$responseNode->code;
        if(!empty($resultCode)&&$resultCode == 10000){
            M('AlipayRefundOrder')->add($result->$responseNode);
            return self::createReturn(true, $result->$responseNode, '退款成功');
        } else {
            $error = $result->$responseNode->sub_msg;
            return self::createReturn(false, $result->$responseNode, $error?$error:'退款失败');
        }
    }

}