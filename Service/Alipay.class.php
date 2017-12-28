<?php
namespace Alipay\Service;

use System\Model\OrderModel;
use System\Service\OrderService;

require_once APP_PATH . 'Alipay/Sdk/wappay/service/AlipayTradeService.php';
require_once APP_PATH . 'Alipay/Sdk/wappay/buildermodel/AlipayTradeWapPayContentBuilder.php';

/**
 * 支付
 * Class Alipay
 * @package Alipay\Service
 */
class Alipay extends BaseService {

    /**
     * 创建支付
     * @param $amount
     * @param $order_no
     * @param string $return_url
     * @param string $body
     * @param string $subject
     * @return bool|mixed|\SimpleXMLElement|string|\提交表单HTML文本
     */
    static function createWappay($amount, $order_no, $return_url = '', $body = '', $subject = '') {
        //超时时间
        $notify_url = U('Alipay/PayNotify/index');
        $timeout_express = "1m";
        $payRequestBuilder = new \AlipayTradeWapPayContentBuilder();
        $payRequestBuilder->setBody($body);
        $payRequestBuilder->setSubject($subject);
        $payRequestBuilder->setOutTradeNo($order_no);
        $payRequestBuilder->setTotalAmount($amount);
        $payRequestBuilder->setTimeExpress($timeout_express);
        $pay_config = [
            'app_id' => self::getAppId(),
            'merchant_private_key' => self::getRsaPrivateKey(),
            'notify_url' => $notify_url,
            'alipay_return_url' => $return_url,
            'charset' => "UTF-8",
            'sign_type' => self::getSignType(),
            'gatewayUrl' => "https://openapi.alipay.com/gateway.do",
            'alipay_public_key' => self::getAlipayrsaPublicKey(),
        ];
        $payResponse = new \AlipayTradeService($pay_config);

        return $payResponse->wapPay($payRequestBuilder, $return_url, $notify_url);
    }

    /**
     * 回调
     * @param array $arr
     */
    static function notify($arr = []) {
        if (!$arr) {
            $arr = $_POST ? $_POST : $_GET;
        }
        $pay_config = [
            'app_id' => self::getAppId(),
            'merchant_private_key' => self::getRsaPrivateKey(),
            'charset' => "UTF-8",
            'sign_type' => self::getSignType(),
            'gatewayUrl' => "https://openapi.alipay.com/gateway.do",
            'alipay_public_key' => self::getAlipayrsaPublicKey(),
        ];
        $alipaySevice = new \AlipayTradeService($pay_config);
        $alipaySevice->writeLog(var_export($arr, true));
        $result = $alipaySevice->check($arr);

        /* 实际验证过程建议商户添加以下校验。
        1、商户需要验证该通知数据中的out_trade_no是否为商户系统中创建的订单号，
        2、判断total_amount是否确实为该订单的实际金额（即商户订单创建时的金额），
        3、校验通知中的seller_id（或者seller_email) 是否为out_trade_no这笔单据的对应的操作方（有的时候，一个商户可能有多个seller_id/seller_email）
        4、验证app_id是否为该商户本身。
        */
        if ($result) {//验证成功
            /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
            //请在这里加上商户的业务逻辑程序代


            //——请根据您的业务逻辑来编写程序（以下代码仅作参考）——

            //获取支付宝的通知返回参数，可参考技术文档中服务器异步通知参数列表

            //商户订单号

            $out_trade_no = $arr['out_trade_no'];

            //支付宝交易号

            $trade_no = $arr['trade_no'];

            //交易状态
            $trade_status = $arr['trade_status'];


            if ($trade_status == 'TRADE_FINISHED') {

                //判断该笔订单是否在商户网站中已经做过处理
                //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                //请务必判断请求时的total_amount与通知时获取的total_fee为一致的
                //如果有做过处理，不执行商户的业务程序

                //注意：
                //退款日期超过可退款期限后（如三个月可退款），支付宝系统发送该交易状态通知
            } else {
                if ($trade_status == 'TRADE_SUCCESS') {
                    //判断该笔订单是否在商户网站中已经做过处理
                    //如果没有做过处理，根据订单号（out_trade_no）在商户网站的订单系统中查到该笔订单的详细，并执行商户的业务程序
                    //请务必判断请求时的total_amount与通知时获取的total_fee为一致的
                    //如果有做过处理，不执行商户的业务程序
                    //注意：
                    //付款完成后，支付宝系统发送该交易状态通知

                    //支付成功Hook
                    //TODO

                    AlipayPay::updateOrderInfo($arr);
                }
            }
            //——请根据您的业务逻辑来编写程序（以上代码仅作参考）——

            echo "success";        //请不要修改或删除

        } else {
            //验证失败
            echo "fail";    //请不要修改或删除

        }
    }
}