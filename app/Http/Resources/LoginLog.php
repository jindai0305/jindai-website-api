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
 * Class LoginLog
 * @package App\Http\Resources
 *
 * @mixin \App\Models\LoginLog
 */
class LoginLog extends JsonResource
{
    use ResourceTrait;

    /**
     * @param $request
     * @return array
     *
     * @SWG\Definition(
     *     definition="loginLogDefault",
     *     type="object",
     *     @SWG\Property(property="id", type="integer", description="用户id", example=1),
     *     @SWG\Property(property="user", type="object", description="用户",
     *         @SWG\Schema(ref="#/definitions/userIndex")
     *     ),
     *     @SWG\Property(property="states", type="integer", description="附加信息", example="微信信息"),
     *     @SWG\Property(property="ip", type="integer", description="登录ip", example="122.231.67.200"),
     *     @SWG\Property(property="agent", type="string", description="登录设备", example="Mozilla/5.0 (Macintosh; Intel Mac OS X 10_14_6) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/78.0.3904.87 Safari/537.36"),
     *     @SWG\Property(property="time", type="integer", description="登录时间", example=1571121619),
     * )
     */
    protected function toDefault($request)
    {
        return [
            'id' => $this->id,
            'user' => $this->resourceInstance(User::class, $this->user),
            'states' => $this->states,
            'ip' => $this->ip,
            'agent' => $this->agent,
            'time' => $this->time,
        ];
    }
}
