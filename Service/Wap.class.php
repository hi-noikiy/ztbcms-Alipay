<?php
namespace Alipay\Service;

class Wap {
    static function createWapPay($out_trade_no, $subject, $total_fee, $body = '', $show_url = '') {
        //获取配置
        $config = cache('Config');

        $alipay_config = [
            'partner' => $config['alipay_partner'],
            'seller_id' => $config['alipay_seller_id'],
            'private_key' => $config['alipay_private_key'],
            'alipay_public_key' => $config['alipay_public_key'],
            'notify_url' => $config['alipay_notify_url'],
            'return_url' => $config['alipay_return_url'],
            'sign_type' => $config['alipay_sign_type'],
            'input_charset' => 'utf-8',
            'cacert' => '',
            'transport' => 'http',
            'payment_type' => '1',
            'service' => 'alipay.wap.create.direct.pay.by.user'
        ];

        $parameter = array(
            "service" => $alipay_config['service'],
            "partner" => $alipay_config['partner'],
            "seller_id" => $alipay_config['seller_id'],
            "payment_type" => $alipay_config['payment_type'],
            "notify_url" => $alipay_config['notify_url'],
            "return_url" => $alipay_config['return_url'],
            "_input_charset" => trim(strtolower(C('Alipay.input_charset'))),
            "out_trade_no" => $out_trade_no,
            "subject" => $subject,
            "total_fee" => $total_fee,
            "show_url" => $show_url,
//            "app_pay"	=> "Y",//启用此参数能唤起钱包APP支付宝
            "body" => $body,
        );

        $alipaySubmit = new AlipaySubmit($alipay_config);
        return $alipaySubmit->buildRequestForm($parameter, 'get', '确认');
    }
}
