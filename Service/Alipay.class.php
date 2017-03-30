<?php
namespace Alipay\Service;

use Payment\Client\Charge;
use Payment\Common\PayException;

class Alipay extends BaseService {
    static function createWappay(
        $amount,
        $order_no,
        $body = '',
        $subject = '',
        $return_param = '',
        $use_sandbox = false
    ) {
        if (!$body) {
            return self::createReturn(false, '', '请输入支付商品介绍');
        }
        if (!$subject) {
            return self::createReturn(false, '', '请输入商品标题');
        }

        $config = cache('Config');
        $alipay_config = [
            'use_sandbox' => $use_sandbox,
            'partner' => $config['alipay_partner'],
            'app_id' => $config['alipay_app_id'],
            'sign_type' => 'RSA',
            'ali_public_key' => $config['alipay_public_key'],
            'rsa_private_key' => $config['alipay_private_key'],
            'limit_pay' => [],
            'notify_url' => $config['alipay_notify_url'],
            'return_url' => $config['alipay_return_url'],
            'return_raw' => true,
        ];
        $channel = 'ali_wap';
        $payData = [
            'body' => $body,
            'subject' => $subject,
            'order_no' => $order_no,
            'timeout_express' => time() + 7 * 86400,
            'amount' => $amount,
            'return_param' => $return_param,
            'goods_type' => 1,
            'store_id' => '',// 没有就不设置
        ];
        try {
            $payUrl = Charge::run($channel, $alipay_config, $payData);
        } catch (PayException $e) {
            // 异常处理
            return self::createReturn(false, '', $e->errorMessage());
        }

        return self::createReturn(true, $payUrl, 'ok');
    }
}