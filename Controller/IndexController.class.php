<?php
namespace Alipay\Controller;

use Alipay\Service\Wap;
use Common\Controller\Base;

class IndexController extends Base {
    public function index() {

        //商户订单号，商户网站订单系统中唯一订单号，必填
        $out_trade_no = date('YmdHis', time());

        //订单名称，必填
        $subject = '测试商品名称';

        //付款金额，必填
        $total_fee = 1;

        //收银台页面上，商品展示的超链接，必填
        $show_url = 'http://zhutibang.cn';

        //商品描述，可空
        $body = '';

        echo Wap::createWapPay($out_trade_no,$subject,$total_fee,$body,$show_url);
    }
}