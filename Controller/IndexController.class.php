<?php
namespace Alipay\Controller;

use Alipay\Service\Alipay;
use Common\Controller\Base;

class IndexController extends Base {
    public function index() {
        redirect(Alipay::createWappay(100, time()));
    }
}