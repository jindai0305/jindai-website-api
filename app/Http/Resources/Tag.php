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
 * Class Cate
 * @package App\Http\Resources
 *
 * @mixin \App\Models\Tag
 */
class Tag extends JsonResource
{
    use ResourceTrait;

    /**
     * @param $request
     * @return array
     *
     * @SWG\Definition(
     *     definition="tagDefault",
     *     type="object",
     *     @SWG\Property(property="id", type="integer", description="id", example=1),
     *     @SWG\Property(property="name", type="string", description="名称", example="计算机网络"),
     *     @SWG\Property(property="created_at", type="integer", description="创建时间", example=1569292862),
     *     @SWG\Property(property="deleted_at", type="integer", description="创建时间", example=1569292862)
     * )
     */
    protected function toDefault($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'status' => $this->status,
            'nums' => $this->items->count(),
            'created_at' => $this->created_at,
            'deleted_at' => $this->deleted_at,
        ];
    }

    /**
     * @param $request
     * @return array
     *
     * @SWG\Definition(
     *     definition="tagIndex",
     *     type="object",
     *     allOf = {
     *          @SWG\Schema(
     *              @SWG\Property(property="id", type="integer", description="id", example=1),
     *              @SWG\Property(property="name", type="string", description="名称", example="计算机网络")
     *          )
     *     }
     * )
     */
    protected function toIndex($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name
        ];
    }
}
