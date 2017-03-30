<?php
namespace Alipay\Controller;

use Alipay\Service\Alipay;
use Common\Controller\Base;

class IndexController extends Base {
    public function index() {
        $pay_res = Alipay::createWappay(100, time(), '商品', '介绍');
        if ($pay_res['status']) {
            redirect($pay_res['data']);
        } else {
            echo $pay_res['msg'];
        }
        exit;
    }
}