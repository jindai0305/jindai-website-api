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
 * Class Banner
 * @package App\Http\Resources
 *
 * @mixin \App\Models\Banner
 */
class Banner extends JsonResource
{
    use ResourceTrait;

    /**
     * @param $request
     * @return array
     *
     * @SWG\Definition(
     *     definition="bannerDefault",
     *     type="object",
     *     @SWG\Property(property="id", type="integer", description="id", example=1),
     *     @SWG\Property(property="title", type="string", description="标题", example="计算机网络"),
     *     @SWG\Property(property="summary", type="string", description="简介", example="计算机网络的历史"),
     *     @SWG\Property(property="image", type="object", description="图片",
     *          @SWG\Property(property="id", type="integer", description="主键id", example=1),
     *          @SWG\Property(property="url", type="string", description="跳转链接", example="https://www.w3school.com.cn//i/eg_tulip.jpg")
     *     ),
     *     @SWG\Property(property="url", type="string", description="跳转链接", example="https://www.lcckup.com"),
     *     @SWG\Property(property="nums", type="integer", description="文章数", example=1),
     *     @SWG\Property(property="created_at", type="integer", description="创建时间", example=1569292862),
     *     @SWG\Property(property="deleted_at", type="integer", description="删除时间", example=1569292862),
     * )
     */
    protected function toDefault($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'summary' => $this->summary,
            'image' => $this->image,
            'url' => $this->url,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'deleted_at' => $this->deleted_at,
        ];
    }

    /**
     * @param $request
     * @return array
     *
     * @SWG\Definition(
     *     definition="bannerIndex",
     *     type="object",
     *     allOf = {
     *          @SWG\Schema(ref="#/definitions/bannerDefault"),
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
     * @param $request
     * @return array
     *
     * @SWG\Definition(
     *     definition="bannerView",
     *     type="object",
     *     allOf = {
     *          @SWG\Schema(ref="#/definitions/bannerDefault"),
     *          @SWG\Schema(
     *          )
     *     }
     * )
     */
    protected function toView($request)
    {
        return array_merge($this->toDefault($request), [
        ]);
    }
}
