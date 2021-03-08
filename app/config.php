<?php

return [
    'rpcHost' => '127.0.0.1',
    'rpcPort' => '8080',
    'worker_num' => 1,

    'email' => [
        'username' => 'cgjcgs@163.com',
        'password' => '123456',
        'host' => 'smtp.163.com',
    ],
    'events' => [
        \app\events\registerAfter::class => [
            \app\observers\sendEmail::class,
            \app\observers\sendSms::class
        ],
    ],

];