<?php
return [
    'alipay' => [
        'use_sandbox' => false,
        'partner' => '2088121696348754',
        'app_id' => '2016102302293152',
        'sign_type' => 'RSA',
        'ali_public_key' => 'MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDDI6d306Q8fIfCOaTXyiUeJHkrIvYISRcc73s3vF1ZT7XN8RNPwJxo8pWaJMmvyTn9N4HQ632qJBVHf8sxHi/fEsraprwCtzvzQETrNRwVxLO5jVmRGi60j8Ue1efIlzPXV9je9mkjzOmdssymZkh2QhUrCmZYI/FCEa3/cNMW0QIDAQAB',
        'rsa_private_key' => APP_PATH . 'Alipay/rsa/rsa_private_key.pem',
        'limit_pay' => [
//            'balance',
            //'moneyFund',
            // ... ...
        ],
        'notify_url' => 'https://yile.sz.ztbweb.cn/',
        'return_url' => 'https://yile.sz.ztbweb.cn/',
        'return_raw' => true,
    ]
];