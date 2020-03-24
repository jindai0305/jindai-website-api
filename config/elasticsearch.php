<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

return [
    'open' => env('ELASTIC_SEARCH', false),
    'config' => [
        'index' => env('ELASTICSEARCH_INDEX', 'elasticsearch'),
        'hosts' => [
            env('ELASTICSEARCH_HOST', 'http://127.0.0.1:9200'),
        ]
    ]
];
