<?php
/**
 * Created by PhpStorm.
 * User: Administrator
 * Date: 2020/6/9
 * Time: 11:14
 */
return [
    'wechat' => [
        'appid' => 'wxb3fxxxxxxxxxxx', // APP APPID
        'app_id' => 'wx0381259271feee75', // 公众号 APPID
        'miniapp_id' => 'wxb3fxxxxxxxxxxx', // 小程序 APPID
        'mch_id' => '1552652221',
        'key' => 'f2a1cdeb50c481ddaa891cf930403156',
        'notify_url' => request()->domain().'/notify/wechat/',
        //'cert_client' => './cert/apiclient_cert.pem', // optional，退款等情况时用到
        //'cert_key' => './cert/apiclient_key.pem',// optional，退款等情况时用到
        'log' => [ // optional
            'file' => '../runtime/log/wechat.log',
            'level' => 'info', // 建议生产环境等级调整为 info，开发环境为 debug
            'type' => 'single', // optional, 可选 daily.
            'max_file' => 30, // optional, 当 type 为 daily 时有效，默认 30 天
        ],
        'http' => [ // optional
            'timeout' => 5.0,
            'connect_timeout' => 5.0,
            // 更多配置项请参考 [Guzzle](https://guzzle-cn.readthedocs.io/zh_CN/latest/request-options.html)
        ],
        //'mode' => 'dev', // optional, dev/hk;当为 `hk` 时，为香港 gateway。
    ]
];