<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;

/**
 * Class DocController
 * @package App\Http\Controllers\Api
 */
class DocController extends Controller
{
    /**
     * 抓取文档前端地址
     * @return false|string
     */
    public function index()
    {
        return file_get_contents(config('website.doc.url'), false, stream_context_create(['ssl' => ['verify_peer' => false]]));
    }

    /**
     * 获取swagger的json
     *
     * @param string $version
     * @return \Swagger\Annotations\Swagger
     */
    public function json($version = 'v1')
    {
        $swagger = \Swagger\scan($this->getScanDir($version));

        return $swagger;
    }

    /**
     * 获取需扫描的文件目录
     *
     * @param $version
     * @return array
     */
    private function getScanDir($version)
    {
        $resource_path = app_path('Http/Resources');
        $swagger_path = app_path('Helpers') . '/swagger.php';
        return [
            __FILE__,
            $resource_path,
            __DIR__ . '/' . $version,
            $swagger_path,
            __DIR__ . '/' . 'DefaultController.php'
        ];
    }
}
