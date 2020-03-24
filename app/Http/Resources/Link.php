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
 * Class Link
 * @package App\Http\Resources
 *
 * @mixin \App\Models\Link
 */
class Link extends JsonResource
{
    use ResourceTrait;

    /**
     * @param $request
     * @return array
     *
     * @SWG\Definition(
     *     definition="linkDefault",
     *     type="object",
     *     allOf = {
     *          @SWG\Schema(ref="#/definitions/modelIdParam"),
     *          @SWG\Schema(ref="#/definitions/linkBodyParams"),
     *          @SWG\Schema(
     *              @SWG\Property(property="user_id", type="integer", description="用户id", example=1),
     *              @SWG\Property(property="created_at", type="integer", description="创建时间", example=1571121619),
     *              @SWG\Property(property="updated_at", type="integer", description="更新时间", example=1571121619),
     *              @SWG\Property(property="deleted_at", type="integer", description="删除时间", example=1571121619),
     *          )
     *     }
     * )
     */
    protected function toDefault($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'icon' => $this->icon,
            'website' => $this->website,
            'summary' => $this->summary,
            'email' => $this->email,
            'user_id' => $this->user_id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'deleted_at' => $this->deleted_at,
        ];
    }

    /**
     * @param $request
     * @return array
     *
     * @SWG\Definition(
     *     definition="linkIndex",
     *     type="object",
     *     allOf = {
     *          @SWG\Schema(
     *              @SWG\Property(property="name", type="string", description="名称", example="计算机网络"),
     *              @SWG\Property(property="icon", type="string", description="名称", example="计算机网络"),
     *              @SWG\Property(property="website", type="string", description="名称", example="计算机网络"),
     *              @SWG\Property(property="summary", type="string", description="名称", example="计算机网络"),
     *          )
     *     }
     * )
     */
    protected function toIndex($request)
    {
        return [
            'name' => $this->name,
            'icon' => $this->icon,
            'website' => $this->website,
            'summary' => $this->summary
        ];
    }
}
