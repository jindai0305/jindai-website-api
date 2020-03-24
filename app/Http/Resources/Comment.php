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
 * Class Comment
 * @package App\Http\Resources
 *
 * @mixin \App\Models\Comment
 */
class Comment extends JsonResource
{
    use ResourceTrait;

    /**
     * @param $request
     * @return array
     *
     * @SWG\Definition(
     *     definition="commentDefault",
     *     type="object",
     *     @SWG\Property(property="id", type="integer", description="id", example=1),
     *     @SWG\Property(property="user", type="object", description="用户",
     *          @SWG\Schema(ref="#/definitions/userIndex")
     *     ),
     *     @SWG\Property(property="item", type="object", description="文章",
     *          @SWG\Schema(ref="#/definitions/itemComment")
     *     ),
     *     @SWG\Property(property="item_id", type="integer", description="文章id", example=1),
     *     @SWG\Property(property="reply_id", type="integer", description="回复的评论id", example=1),
     *     @SWG\Property(property="content", type="string", description="内容", example="这是一个评论"),
     *     @SWG\Property(property="favor", type="integer", description="点赞数", example=10),
     *     @SWG\Property(property="status", type="integer", description="状态", example=1),
     *     @SWG\Property(property="created_at", type="integer", description="创建时间", example=1569292862),
     * )
     */
    protected function toDefault($request)
    {
        return [
            'id' => $this->id,
            'user' => $this->resourceInstance(User::class, $this->user),
            'item' => $this->resourceInstance(Item::class, $this->item)->setStamp('comment'),
            'item_id' => $this->item_id,
            'reply_id' => $this->reply_id,
            'content' => $this->content,
            'favor' => $this->favor,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'deleted_at' => $this->deleted_at
        ];
    }

    /**
     * @param $request
     * @return array
     *
     * @SWG\Definition(
     *     definition="commentIndex",
     *     type="object",
     *     allOf = {
     *          @SWG\Schema(ref="#/definitions/commentDefault"),
     *          @SWG\Schema(
     *              @SWG\Property(property="nums", type="integer", description="文章数量", example=1),
     *          )
     *     }
     * )
     */
    protected function toIndex($request)
    {
        return array_merge($this->toDefault($request), [
        ]);
    }
}
