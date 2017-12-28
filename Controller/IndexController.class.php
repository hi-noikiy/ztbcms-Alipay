<?php
namespace Alipay\Controller;

use Alipay\Service\Alipay;
use Common\Controller\Base;

class IndexController extends Base {

    /**
     * 支付测试
     *
     */
    public function index(){
        $total_pay = 0.01; //支付金额(元)
        $order_sn = time(); //订单号
        $body = ''; //支付内容介绍
        $title = '商品名称'; //支付标题
        $redirect_url = 'http://www.zhutibang.cn'; //支付完跳转
        Alipay::createWappay($total_pay, $order_sn, $redirect_url, $body, $title);
    }

}