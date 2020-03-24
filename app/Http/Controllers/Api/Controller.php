<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller as BaseController;
use App\Support\Response;
use Illuminate\Http\Request;

/**
 * Class Controller
 * @package App\Http\Controllers\Api
 *
 * @property-read Response $response
 */
class Controller extends BaseController
{
    /**
     * @param $class
     * @param $model
     * @return \App\Http\Resources\Item|array|object
     */
    protected function resourceInstance($class, $model)
    {
        return new $class($model);
    }

    /**
     * @param Request $request
     * @param array $append
     * @return Request
     */
    protected function offsetRequest(Request $request, $append = [])
    {
        foreach ($append as $key => $value) {
            $request->offsetSet($key, $value);
        }
        return $request;
    }
}
