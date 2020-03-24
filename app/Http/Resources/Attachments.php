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
 * Class Attachments
 * @package App\Http\Resources
 *
 * @mixin \App\Models\Attachments
 */
class Attachments extends JsonResource
{
    use ResourceTrait;

    /**
     * @param $request
     * @return array
     *
     * @SWG\Definition(
     *     definition="attachmentsDefault",
     *     type="object",
     *     @SWG\Property(property="id", type="integer", description="id", example=1),
     *     @SWG\Property(property="name", type="string", description="名称", example="abc"),
     *     @SWG\Property(property="type", type="string", description="类型", example="avatar"),
     *     @SWG\Property(property="url", type="string", description="链接", example="/path/to/image"),
     * )
     */
    protected function toDefault($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'type' => $this->type,
            'url' => $this->url
        ];
    }
}
