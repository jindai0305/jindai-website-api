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
 * Class Item
 * @package App\Http\Resources
 *
 * @mixin \App\Models\Item
 */
class Item extends JsonResource
{
    use ResourceTrait;

    /**
     * @param $request
     * @return array
     *
     * @SWG\Definition(
     *     definition="itemDefault",
     *     type="object",
     *     allOf = {
     *          @SWG\Schema(ref="#/definitions/modelIdParam"),
     *          @SWG\Schema(ref="#/definitions/itemBodyParams"),
     *          @SWG\Schema(
     *              @SWG\Property(property="view_nums", type="integer", description="查看数量", example=1),
     *              @SWG\Property(property="approve_nums", type="integer", description="点赞数量", example=1),
     *              @SWG\Property(property="comment_nums", type="integer", description="评论数量", example=1),
     *              @SWG\Property(property="cate", type="object", description="评论数量",
     *                  ref="#/definitions/cateItem"
     *              ),
     *              @SWG\Property(property="tag_list", type="array", description="商品",
     *                   @SWG\Items(ref="#/definitions/tagIndex"),
     *              ),
     *          ),
     *          @SWG\Schema(ref="#/definitions/timeCreateParam"),
     *     }
     * )
     */
    protected function toDefault($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'cate_id' => $this->cate_id,
            'cate' => $this->resourceInstance(Cate::class, $this->cate)->setStamp('item'),
            'tag_list' => $this->resourceInstance(TagCollection::class, $this->tags)->setStamp('index'),
            'summary' => $this->summary,
            'image' => $this->image,
            'chosen' => $this->chosen,
            'type' => $this->type,
            'status' => $this->status,
            'allow_comment' => $this->allow_comment,
            'copyright' => $this->copyright,
            'original_link' => $this->original_link,
            'view_nums' => $this->view_nums,
            'approve_nums' => $this->approve_nums,
            'comment_nums' => $this->comment_nums,
            'created_at' => $this->created_at,
            'deleted_at' => $this->deleted_at,
        ];
    }

    /**
     * @param $request
     * @return array
     *
     * @SWG\Definition(
     *     definition="itemIndex",
     *     type="object",
     *     allOf = {
     *          @SWG\Schema(ref="#/definitions/modelIdParam"),
     *          @SWG\Schema(ref="#/definitions/itemBodyParams"),
     *          @SWG\Schema(
     *              @SWG\Property(property="view_nums", type="integer", description="查看数量", example=1),
     *              @SWG\Property(property="approve_nums", type="integer", description="点赞数量", example=1),
     *              @SWG\Property(property="comment_nums", type="integer", description="评论数量", example=1),
     *              @SWG\Property(property="cate", type="object", description="评论数量",
     *                  ref="#/definitions/cateItem"
     *              ),
     *              @SWG\Property(property="tag_list", type="array", description="商品",
     *                   @SWG\Items(ref="#/definitions/tagIndex"),
     *              ),
     *          ),
     *          @SWG\Schema(ref="#/definitions/timeCreateParam"),
     *     }
     * )
     */
    protected function toIndex($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'cate_id' => $this->cate_id,
            'cate' => $this->resourceInstance(Cate::class, $this->cate)->setStamp('item'),
            'tag_list' => $this->resourceInstance(TagCollection::class, $this->tags)->setStamp('index'),
            'summary' => $this->summary,
            'image' => $this->image,
            'content' => $this->content,
            'chosen' => $this->chosen,
            'type' => $this->type,
            'allow_comment' => $this->allow_comment,
            'copyright' => $this->copyright,
            'original_link' => $this->original_link,
            'view_nums' => $this->view_nums,
            'approve_nums' => $this->approve_nums,
            'comment_nums' => $this->comment_nums,
            'created_at' => $this->created_at,
        ];
    }

    /**
     * @param $request
     * @return array
     *
     * @SWG\Definition(
     *     definition="itemEdit",
     *     type="object",
     *     allOf = {
     *          @SWG\Schema(ref="#/definitions/modelIdParam"),
     *          @SWG\Schema(ref="#/definitions/itemBodyParams"),
     *          @SWG\Schema(
     *              @SWG\Property(property="view_nums", type="integer", description="查看数量", example=1),
     *              @SWG\Property(property="approve_nums", type="integer", description="点赞数量", example=1),
     *              @SWG\Property(property="comment_nums", type="integer", description="评论数量", example=1),
     *              @SWG\Property(property="is_collect", type="boolean", description="是否收藏", example=true),
     *              @SWG\Property(property="is_approve", type="boolean", description="是否点赞", example=true),
     *              @SWG\Property(property="cate", type="object", description="评论数量",
     *                  ref="#/definitions/cateItem"
     *              ),
     *              @SWG\Property(property="tag_list", type="array", description="商品",
     *                   @SWG\Items(ref="#/definitions/tagIndex"),
     *              ),
     *          ),
     *          @SWG\Schema(ref="#/definitions/timeCreateParam"),
     *     }
     * )
     */
    protected function toEdit($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'summary' => $this->summary,
            'cate_id' => $this->cate_id,
            'image' => $this->image,
            'keywords' => $this->keywords,
            'tag_list' => $this->resourceInstance(TagCollection::class, $this->tags)->setStamp('index'),
            'content' => $this->content,
            'type' => $this->type,
            'allow_comment' => $this->allow_comment,
            'copyright' => $this->copyright,
            'original_website' => $this->original_website,
            'original_link' => $this->original_link,
            'chosen' => $this->chosen,
            'status' => $this->status,
        ];
    }

    /**
     * @param $request
     * @return array
     *
     * @SWG\Definition(
     *     definition="itemView",
     *     type="object",
     *     allOf = {
     *          @SWG\Schema(ref="#/definitions/modelIdParam"),
     *          @SWG\Schema(ref="#/definitions/itemBodyParams"),
     *          @SWG\Schema(
     *              @SWG\Property(property="view_nums", type="integer", description="查看数量", example=1),
     *              @SWG\Property(property="approve_nums", type="integer", description="点赞数量", example=1),
     *              @SWG\Property(property="comment_nums", type="integer", description="评论数量", example=1),
     *              @SWG\Property(property="is_collect", type="boolean", description="是否收藏", example=true),
     *              @SWG\Property(property="is_approve", type="boolean", description="是否点赞", example=true),
     *              @SWG\Property(property="cate", type="object", description="评论数量",
     *                  ref="#/definitions/cateItem"
     *              ),
     *              @SWG\Property(property="tag_list", type="array", description="商品",
     *                   @SWG\Items(ref="#/definitions/tagIndex"),
     *              ),
     *          ),
     *          @SWG\Schema(ref="#/definitions/timeCreateParam"),
     *     }
     * )
     */
    protected function toView($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'cate_id' => $this->cate_id,
            'cate' => $this->resourceInstance(Cate::class, $this->cate)->setStamp('item'),
            'tag_list' => $this->resourceInstance(TagCollection::class, $this->tags)->setStamp('index'),
            'keywords' => $this->keywords,
            'summary' => $this->summary,
            'image' => $this->image,
            'content' => $this->content,
            'chosen' => $this->chosen,
            'type' => $this->type,
            'allow_comment' => $this->allow_comment,
            'copyright' => $this->copyright,
            'original_link' => $this->original_link,
            'original_website' => $this->original_website,
            'view_nums' => $this->view_nums,
            'approve_nums' => $this->approve_nums,
            'comment_nums' => $this->comment_nums,
            'status' => $this->status,
            'is_collect' => $this->isCollect(),
            'is_approve' => $this->isApprove(),
            'created_at' => $this->created_at,
        ];
    }

    /**
     * @param $request
     * @return array
     *
     * @SWG\Definition(
     *     definition="itemComment",
     *     type="object",
     *     @SWG\Schema(
     *         @SWG\Property(property="id", type="integer", description="文章id", example=1),
     *         @SWG\Property(property="title", type="string", description="文章标题", example="文章标题"),
     *     )
     * )
     */
    protected function toComment($request)
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
        ];
    }
}
