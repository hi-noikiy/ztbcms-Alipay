<?php
namespace Alipay\Controller;

use Alipay\Service\Alipay;
use Common\Controller\Base;

class IndexController extends Base {
    public function index() {
        $pay_res = Alipay::createWappay(0.01, time(), '订单介绍', '商品标题');
        if ($pay_res['status']) {
            redirect($pay_res['data']);
        } else {
            echo $pay_res['msg'];
        }
        exit;
    }

    public function notify() {
        Alipay::notify($_POST);
    }

}