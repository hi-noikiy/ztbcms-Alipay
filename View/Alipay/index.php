<?php if (!defined('CMS_VERSION')) {
    exit();
} ?>
<Admintemplate file="Common/Head"/>
<body>
<style>
    td {
        padding: 10px 5px;
    }
</style>
<div class="wrap">
    <div id="home_toptip"></div>
    <h2 class="h_a">支付设置</h2>
    <div class="home_info" id="app">
        <form id="form_data">
            <table style="width: 100%;">
                <tbody>
                <tr>
                    <td width="100px"><label for="">partner</label></td>
                    <td>
                        <input placeholder="合作身份者ID，签约账号" value="{$config.alipay_partner}" name="alipay_partner" style="width:300px;"
                               class="form-control"
                               type="text"></td>
                </tr>
                <tr>
                    <td width="100px"><label for="">app_id</label></td>
                    <td><input placeholder="app_id" value="{$config.alipay_app_id}" name="alipay_app_id"
                               style="width:300px;"
                               class="form-control" type="text"></td>
                </tr>
                <tr>
                    <td width="100px"><label for="">notify_url</label></td>
                    <td><input placeholder="异步通知url，可以调用才指定" value="{$config.alipay_notify_url}" name="alipay_notify_url"
                               style="width:300px;" class="form-control"
                               type="text"></td>
                </tr>
                <tr>
                    <td width="100px"><label for="">return_url</label></td>
                    <td><input placeholder="支付完成跳转url，可以调用才指定" value="{$config.alipay_return_url}" name="alipay_return_url"
                               style="width:300px;"
                               class="form-control"
                               type="text"></td>
                </tr>
                <tr>
                    <td width="100px"><label for="">alipay_public_key</label></td>
                    <td>
                        <textarea placeholder="支付宝公钥" name="alipay_public_key"
                                  style="width:500px;height: 200px;">{$config.alipay_public_key}</textarea>
                    </td>
                </tr>
                <tr>
                    <td width="100px"><label for="">private_key</label></td>
                    <td>
                        <textarea placeholder="私钥" name="alipay_private_key" style="width:500px;height: 300px;">{$config.alipay_private_key}</textarea>
                    </td>
                </tr>
                </tbody>
            </table>
        </form>
        <div>
            <a @click="submitBtn" class="btn btn-primary" href="javascript:;">保存</a>
        </div>
    </div>
</div>
<script src="{$config_siteurl}statics/js/common.js"></script>
<script src="{$config_siteurl}statics/js/artDialog/artDialog.js"></script>
<script src="//cdn.bootcss.com/vue/2.2.4/vue.js"></script>
<script>
    $(document).ready(function () {
        new Vue({
            el: '#app',
            data: {},
            methods: {
                submitBtn: function () {
                    console.log('xx')
                    $.ajax({
                        url: "{:U('index')}",
                        data: $('#form_data').serialize(),
                        dataType: 'json',
                        type: 'post',
                        success: function (res) {
                            if (res.status) {
                                location.reload()
                            } else {
                                alert(res.info)
                            }
                        }
                    })
                }
            },
            mounted: function () {

            }
        })
    })
</script>
</body>
</html>
