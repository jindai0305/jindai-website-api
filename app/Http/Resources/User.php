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
 * Class User
 * @package App\Http\Resources
 *
 * @mixin \App\Models\User
 */
class User extends JsonResource
{
    use ResourceTrait;

    /**
     * @param $request
     * @return array
     *
     * @SWG\Definition(
     *     definition="userDefault",
     *     type="object",
     *     @SWG\Property(property="id", type="integer", description="id", example=1),
     *     @SWG\Property(property="name", type="string", description="名称", example="用户"),
     *     @SWG\Property(property="email", type="string", description="邮箱", example="email@163.com"),
     *     @SWG\Property(property="score", type="integer", description="活跃积分", example=100),
     *     @SWG\Property(property="nick_name", type="string", description="昵称", example="abc"),
     *     @SWG\Property(property="avatar", type="string", description="头像", example="计算机网络"),
     *     @SWG\Property(property="website", type="string", description="网站", example="http://www.baidu.com"),
     *     @SWG\Property(property="signature", type="string", description="个人简介", example="个人简介"),
     *     @SWG\Property(property="active_at", type="integer", description="最后活动时间", example=1576057054),
     *     @SWG\Property(property="created_at", type="integer", description="注册时间", example=1576057054),
     *     @SWG\Property(property="is_super", type="boolean", description="超管", example=true),
     *     @SWG\Property(property="is_admin", type="boolean", description="管理员", example=true),
     *     @SWG\Property(property="roles", type="array", description="特殊身份",
     *          @SWG\Items(type="string",example="管理员")
     *     ),
     *     @SWG\Property(property="is_unusual", type="boolean", description="账号是否异常", example=true),
     *     @SWG\Property(property="is_disabled", type="boolean", description="是否禁用", example=true),
     *     @SWG\Property(property="is_muted", type="boolean", description="是否禁言", example=true)
     * )
     */
    protected function toDefault($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'score' => $this->score,
            'nick_name' => $this->userExpand->nick_name,
            'avatar' => $this->userExpand->avatar,
            'website' => $this->userExpand->website,
            'signature' => $this->userExpand->signature,
            'active_at' => $this->userExpand->active_at,
            'created_at' => $this->created_at,
            'is_super' => (boolean)$this->is_super,
            'is_admin' => $this->isAdmin(),
            'roles' => $this->getAccountRoles(),
            'is_unusual' => $this->isUnusual(),
            'is_disabled' => $this->isDisabled(),
            'is_muted' => $this->isMuted()
        ];
    }

    /**
     * @param $request
     * @return array
     *
     * @SWG\Definition(
     *     definition="userIndex",
     *     type="object",
     *     allOf = {
     *          @SWG\Schema(ref="#/definitions/userDefault"),
     *          @SWG\Schema(
     *          )
     *     }
     * )
     */
    protected function toIndex($request)
    {
        return array_merge($this->toDefault($request), [
        ]);
    }

    /**
     *
     * @SWG\Definition(
     *     definition="userView",
     *     type="object",
     *     @SWG\Property(property="id", type="integer", description="id", example=1),
     *     @SWG\Property(property="name", type="string", description="名称", example="用户"),
     *     @SWG\Property(property="nick_name", type="string", description="昵称", example="abc"),
     *     @SWG\Property(property="avatar", type="string", description="头像", example="计算机网络"),
     *     @SWG\Property(property="website", type="string", description="网站", example="http://www.baidu.com"),
     *     @SWG\Property(property="signature", type="string", description="个人简介", example="个人简介"),
     *     @SWG\Property(property="active_at", type="integer", description="最后活动时间", example=1576057054),
     *     @SWG\Property(property="is_disabled", type="boolean", description="是否禁用", example=true),
     *     @SWG\Property(property="is_speak_banned", type="boolean", description="是否禁言", example=true)
     * )
     */
    protected function toView()
    {

    }
}
