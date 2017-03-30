<?php
namespace Alipay\Controller;

use Common\Controller\AdminBase;

class AlipayController extends AdminBase {
    public function index() {
        if (IS_POST) {
            $post = $_POST;
            foreach ($post as $key => $value) {
                $is_exsit = D('Config')->where("varname='%s'", $key)->find();
                if ($is_exsit) {
                    $data = array('varname' => $key, 'value' => $value, 'groupid' => 20);
                    D('Config')->where("id='%d'", $is_exsit['id'])->save($data);
                } else {
                    $data = array('varname' => $key, 'value' => $value, 'groupid' => 20);
                    D('Config')->add($data);
                }
            }
            $this->success('设置成功');
        } else {
            $this->assign('config', cache('Config'));
            $this->display();
        }
    }
}