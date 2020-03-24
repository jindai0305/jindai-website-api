<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

return [
    'default' => [
        'avatar' => 'https://cube.elemecdn.com/3/7c/3ea6beec64369c2642b92c6726f1epng.png',
    ],
    'token' => [
        'bearer' => 'Bearer ',
        'access' => [
            'name' => 'access_token',
            'expired' => 15
        ],
        'refresh' => [
            'name' => 'refresh_token',
            'expired' => 30
        ],
        'min_length' => 17,
    ],
    'setting' => [
        'id' => env('SETTING_ID', 1)
    ],
    'passport' => [
        'client_id' => env('PASSPORT_CLIENT_ID', 1),
        'client_secret' => env('PASSPORT_CLIENT_SECRET', ''),
    ],
    'doc' => [
        'url' => env('DOC_TEMPLATE_URL', 'https://doc.lcckup.com')
    ]
];
