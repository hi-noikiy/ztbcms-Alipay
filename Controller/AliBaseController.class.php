<?php
namespace Alipay\Controller;

use Alipay\Service\AuthService;
use Common\Controller\Base;

/**
 * 支付宝 http://open.alipay.com
 * Class AliBaseController
 * @package Alipay\Controller
 */
class AliBaseController extends Base {

    public $ali_user_info = array();

    protected function _initialize(){
        parent::_initialize();

        $is_alipay = strpos($_SERVER['HTTP_USER_AGENT'], 'AlipayClient') !== false;
        if ($is_alipay) {
            $appid = AuthService::getAppId();

            if (empty($appid)) {
                $this->error('缺少参数 app_id');
                return;
            }

            if (!I('get.auth_code')) {
                if(session('ali_user_info') && session('ali_user_info')['access_token_expires'] > time()){
                    $this->ali_user_info = session('ali_user_info');

                }else{

                    $redirect_uri = get_url();
                    $scope = 'auth_userinfo,auth_zhima'; //授权权限 => 用户信息+芝麻信用
                    $url ="https://openauth.alipay.com/oauth2/publicAppAuthorize.htm?app_id={$appid}&scope={$scope}&redirect_uri={$redirect_uri}";
                    redirect($url);
                }
            }else{

                $ali_user_info = AuthService::getUserInfo(I('get.auth_code'));
                session('ali_user_info', $ali_user_info);
                $this->ali_user_info = $ali_user_info;

            }


            //最后的结果都是  $this->ali_user_info 有信息
            $binding = M('Alipay')->where([
                "alipay_user_id" => $this->ali_user_info['alipay_user_id']
            ])->find();

            if ($binding) {
                M('Alipay')->where(["id" => $binding['id']])->save([
                    'access_token' => $this->ali_user_info['access_token'],
                    'access_token_expires' => $this->ali_user_info['access_token_expires']
                ]);
                //检查是否有会员登录，有会员登录自动绑定会员信息
                $userinfo = service("Passport")->getInfo();
                if ($userinfo) {
                    //如果不是绑定的原有支付宝，则取消该绑定，绑定现有的支付宝
                    M('Alipay')->where(["id" => $binding['id']])->save(array('userid' => $userinfo['userid']));
                }
            } else {
                //删除id，避免授权请求链接带有ID的情况下，引致的数据库插入错误
                unset($this->ali_user_info['id']);
                M('Alipay')->add($this->ali_user_info);
            }

        }
    }

}