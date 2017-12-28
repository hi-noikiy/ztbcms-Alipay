<?php
namespace Alipay\Controller;

use Alipay\Service\Alipay;
use Common\Controller\Base;

class PayNotifyController extends Base {

    /**
     * 支付完成回调
     * 回调日志 https://openmonitor.alipay.com/acceptance/cloudparse.htm
     */
    public function index() {

        $data = $_POST ? $_POST : $_GET;
        Alipay::notify($data);
    }

}