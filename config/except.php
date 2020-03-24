<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

return [
    'open' => env('RECORD_LOG_DEBUG', true),
    // 方法
    'method' => ['OPTIONS'],
    // 路由
    'router' => ['api/doc/json', 'api/doc'],
    // 控制器
    'controller' => ['LogController', 'DefaultController']
];
