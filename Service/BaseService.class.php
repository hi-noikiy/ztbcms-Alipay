<?php
namespace Alipay\Service;

class BaseService {
    /**
     * 创建统一的Service返回结果
     *
     * @param boolean $status
     * @param array   $data
     * @param string  $msg
     * @return array
     */
    protected static function createReturn($status, $data = [], $msg = '') {
        return [
            'status' => $status,
            'data' => $data,
            'msg' => $msg
        ];
    }
}