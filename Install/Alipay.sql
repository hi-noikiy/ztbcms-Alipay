DROP TABLE IF EXISTS `cms_alipay`;
-- 用户授权信息
CREATE TABLE `cms_alipay` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `userid` int(11) NOT NULL,
  `avatar` varchar(255) NOT NULL DEFAULT '' COMMENT '用户头像',
  `nick_name` varchar(255) NOT NULL DEFAULT '' COMMENT '用户昵称',
  `province` varchar(11) NOT NULL COMMENT '省份',
  `city` varchar(11) NOT NULL COMMENT '城市',
  `gender` varchar(1) NOT NULL COMMENT '性别 M为男性，F为女性，',
  `user_type_value` varchar(1) NOT NULL COMMENT '用户类型 1代表公司账户；2代表个人账户',
  `is_licence_auth` varchar(1) NOT NULL COMMENT '是否经过营业执照认证 T为通过营业执照认证，F为没有通过',
  `is_certified` varchar(1) NOT NULL COMMENT '是否通过实名认证 T是通过；F是没有实名认证',
  `is_certify_grade_a` varchar(1) NOT NULL COMMENT '是否A类认证 T表示是A类认证，F表示非A类认证，A类认证用户是指上传过身份证照片并且通过审核的支付宝用户',
  `is_student_certified` varchar(1) NOT NULL COMMENT '是否是学生',
  `is_bank_auth` varchar(1) NOT NULL COMMENT '是否经过银行卡认证',
  `is_mobile_auth` varchar(1) NOT NULL COMMENT '是否经过手机认证',
  `alipay_user_id` varchar(255) NOT NULL COMMENT '当前用户的userId',
  `user_status` varchar(1) NOT NULL COMMENT '用户状态 Q代表快速注册用户；T代表已认证用户；B代表被冻结账户；W代表已注册，未激活的账户',
  `is_id_auth` varchar(1) NOT NULL COMMENT '是否身份证认证 	T为是身份证认证，F为非身份证认证',
  `login_code` varchar(255) NOT NULL COMMENT '授权登录码',
  `access_token` varchar(255) NOT NULL,
  `access_token_expires` int(11) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `cms_alipay_pay_order`;
-- 订单信息
CREATE TABLE `cms_alipay_pay_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `app_id` varchar(255) NOT NULL,
  `auth_app_id` varchar(255) NOT NULL,
  `buyer_id` varchar(255) NOT NULL,
  `buyer_logon_id` varchar(255) NOT NULL,
  `buyer_pay_amount` varchar(255) NOT NULL,
  `charset` varchar(255) NOT NULL,
  `gmt_create` varchar(255) NOT NULL,
  `gmt_payment` varchar(255) NOT NULL,
  `invoice_amount` varchar(255) NOT NULL,
  `notify_id` varchar(255) NOT NULL,
  `notify_time` varchar(255) NOT NULL,
  `notify_type` varchar(255) NOT NULL,
  `out_trade_no` varchar(255) NOT NULL,
  `point_amount` varchar(255) NOT NULL,
  `receipt_amount` varchar(255) NOT NULL,
  `seller_email` varchar(255) NOT NULL,
  `seller_id` varchar(255) NOT NULL,
  `sign` varchar(255) NOT NULL,
  `sign_type` varchar(255) NOT NULL,
  `subject` varchar(255) NOT NULL,
  `total_amount` varchar(255) NOT NULL,
  `trade_no` varchar(255) NOT NULL,
  `trade_status` varchar(255) NOT NULL,
  `version` varchar(255) NOT NULL,
  `fund_bill_list` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;


DROP TABLE IF EXISTS `cms_alipay_refund_order`;
-- 退款信息
CREATE TABLE `cms_alipay_refund_order` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `code` varchar(255) NOT NULL,
  `msg` varchar(255) NOT NULL,
  `buyer_logon_id` varchar(255) NOT NULL,
  `buyer_user_id` varchar(255) NOT NULL,
  `fund_change` varchar(255) NOT NULL,
  `gmt_refund_pay` varchar(255) NOT NULL,
  `out_trade_no` varchar(255) NOT NULL,
  `refund_fee` varchar(255) NOT NULL,
  `send_back_fee` varchar(255) NOT NULL,
  `trade_no` varchar(255) NOT NULL,
  `sub_code` varchar(255) NOT NULL,
  `sub_msg` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
