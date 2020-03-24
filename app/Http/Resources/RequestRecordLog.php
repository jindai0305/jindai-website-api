<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 Jindai.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Http\Resources;

use App\Traits\ResourceTrait;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class RequestRecordLog
 * @package App\Http\Resources
 *
 * @mixin \App\Models\RequestRecordLog
 */
class RequestRecordLog extends JsonResource
{
    use ResourceTrait;

    /**
     * @param $request
     * @return array
     *
     * @SWG\Definition(
     *     definition="requestRecordLogDefault",
     *     type="object",
     *     @SWG\Property(property="id", type="integer", description="id", example=1),
     *     @SWG\Property(property="user", type="object", description="用户",
     *         @SWG\Schema(ref="#/definitions/userIndex")
     *     ),
     *     @SWG\Property(property="time", type="integer", description="发生时间", example=1575022635),
     *     @SWG\Property(property="ip", type="string", description="登录ip", example="122.231.67.200"),
     *     @SWG\Property(property="module", type="string", description="访问控制器与方法", example="App\Http\Controllers\Api\v1\CateController@index"),
     *     @SWG\Property(property="method", type="string", description="请求方法类型", example="GET"),
     *     @SWG\Property(property="router", type="string", description="路由", example="api/v1/cates"),
     *     @SWG\Property(property="exec_time", type="integer", description="执行时间", example=10),
     *     @SWG\Property(property="status", type="integer", description="执行状态", example=200),
     *     @SWG\Property(property="user_agent", type="string", description="登录设备", example="Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.87 Safari/537.36"),
     * )
     */
    protected function toDefault($request)
    {
        return [
            'id' => $this->id,
            'user' => $this->resourceInstance(User::class, $this->user),
            'time' => $this->time,
            'ip' => $this->ip,
            'module' => $this->module,
            'method' => $this->method,
            'router' => $this->router,
            'exec_time' => $this->exec_time,
            'status' => $this->status,
            'user_agent' => $this->user_agent,
        ];
    }

    /**
     * @param $request
     * @return array
     *
     * @SWG\Definition(
     *     definition="requestRecordLogView",
     *     type="object",
     *     @SWG\Property(property="id", type="integer", description="id", example=1),
     *     @SWG\Property(property="user", type="object", description="用户",
     *         @SWG\Schema(ref="#/definitions/userIndex")
     *     ),
     *     @SWG\Property(property="time", type="integer", description="发生时间", example=1575022635),
     *     @SWG\Property(property="ip", type="string", description="登录ip", example="122.231.67.200"),
     *     @SWG\Property(property="module", type="string", description="访问控制器与方法", example="App\Http\Controllers\Api\v1\CateController@index"),
     *     @SWG\Property(property="method", type="string", description="请求方法类型", example="GET"),
     *     @SWG\Property(property="router", type="string", description="路由", example="api/v1/cates"),
     *     @SWG\Property(property="exec_time", type="integer", description="执行时间", example=10),
     *     @SWG\Property(property="status", type="integer", description="执行状态", example=200),
     *     @SWG\Property(property="response", type="string", description="执行结果", example="json"),
     *     @SWG\Property(property="user_agent", type="string", description="登录设备", example="Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.87 Safari/537.36"),
     *     @SWG\Property(property="header", type="string", description="请求头", example="json"),
     *     @SWG\Property(property="body_params", type="string", description="请求参数", example="json"),
     * )
     */
    protected function toView($request)
    {
        return [
            'id' => $this->id,
            'user' => $this->resourceInstance(User::class, $this->user),
            'time' => $this->time,
            'ip' => $this->ip,
            'module' => $this->module,
            'method' => $this->method,
            'router' => $this->router,
            'exec_time' => $this->exec_time,
            'status' => $this->status,
            'response' => $this->response,
            'user_agent' => $this->user_agent,
            'header' => $this->header,
            'body_params' => $this->body_params,
        ];
    }
}
