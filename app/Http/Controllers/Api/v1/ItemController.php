<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Http\Controllers\Api\v1;


use App\Http\Resources\Item;
use App\Http\Resources\ItemCollection;
use App\Jobs\CoverAboutMeHtml;
use App\Models\UserRelation;
use App\Repositories\ItemRepository;
use Illuminate\Http\Request;

/**
 * Class ItemController
 * @package App\Http\Controllers\Api\v1
 *
 * @SWG\Tag(name="Item", description="文章")
 */
class ItemController extends Controller
{
    /**
     * @inheritdoc
     */
    public function __construct(ItemRepository $model)
    {
        parent::__construct();
        $this->_model = $model;
    }

    /**
     * 获取文章列表
     *
     * @param Request $request
     * @return array
     *
     * @SWG\Get(path="/items",
     *     tags={"Item"},
     *     description="获取文章列表",
     *     produces={"application/json"},
     *     @SWG\Parameter(in="query", name="q", type="string", description="搜索内容 按标题"),
     *     @SWG\Parameter(ref="#/parameters/offsetPageParam"),
     *     @SWG\Parameter(ref="#/parameters/offsetLimitParam"),
     *     @SWG\Response(response=200, description="success",
     *          @SWG\Schema(type="array",
     *              @SWG\Items(ref="#/definitions/itemIndex"),
     *          )
     *     ),
     *     @SWG\Response(response=400,description="failed"),
     *     @SWG\Response(response=401, description="未登录")
     * )
     */
    public function index(Request $request)
    {
        $list = $this->model->paginate($request);
        return $this->resourceInstance(ItemCollection::class, $list)
            ->setStamp('index')
            ->addMeta($this->model->getMeta($request));
    }

    /**
     * 获取文章详情
     * @param $id
     * @return object
     *
     * @SWG\Get(path="/item/{id}",
     *     tags={"Item"},
     *     summary="获取文章详情",
     *     description="获取文章详情",
     *     security={{"api_key": {}}},
     *     deprecated=false,
     *     @SWG\Parameter(name="id",type="integer",in="path",description="资源id",required=true,default=1),
     *     @SWG\Response(response=200,description="success",
     *          @SWG\Schema(ref="#/definitions/itemView")
     *     ),
     *     @SWG\Response(response=400,description="failed"),
     *     @SWG\Response(response=401,description="未登录")
     * )
     */
    public function view($id)
    {
        return $this->resourceInstance(Item::class, $this->model->findModel($id))
            ->setStamp('view');
    }

    /**
     * 文章点赞事件
     * @param $id
     *
     * @SWG\Put(path="/item/{id}/approve",
     *     tags={"Item"},
     *     summary="文章点赞事件",
     *     description="文章点赞事件",
     *     security={{"api_key": {}}},
     *     deprecated=false,
     *     @SWG\Parameter(name="id",type="integer",in="path",description="资源id",required=true,default=1),
     *     @SWG\Response(response=200,description="success"),
     *     @SWG\Response(response=400,description="failed"),
     *     @SWG\Response(response=401,description="未登录")
     * )
     */
    public function toggleApprove($id)
    {
        /** @var \App\Models\Item $model */
        $model = $this->model->findModel($id);

        if (!$relation = $model->userRelation) {
            $relation = $model->userRelation()->create([
                'user_id' => $this->user->id,
                'relation_id' => $model->id,
                'type' => UserRelation::TYPE_ITEM,
            ]);
        }
        $relation->toggleRelation(UserRelation::FLAG_APPROVE, 'approve_nums');
    }

    /**
     * 文章收藏事件
     * @param $id
     *
     * @SWG\Put(path="/item/{id}/collect",
     *     tags={"Item"},
     *     summary="文章收藏事件",
     *     description="文章收藏事件",
     *     security={{"api_key": {}}},
     *     deprecated=false,
     *     @SWG\Parameter(name="id",type="integer",in="path",description="资源id",required=true,default=1),
     *     @SWG\Response(response=200,description="success"),
     *     @SWG\Response(response=400,description="failed"),
     *     @SWG\Response(response=401,description="未登录")
     * )
     */
    public function toggleCollect($id)
    {
        /** @var \App\Models\Item $model */
        $model = $this->model->findModel($id);

        if (!$relation = $model->userRelation) {
            $relation = $model->userRelation()->create([
                'user_id' => $this->user->id,
                'relation_id' => $model->id,
                'type' => UserRelation::TYPE_ITEM,
            ]);
        }
        $relation->toggleRelation(UserRelation::FLAG_COLLECT, 'collect_nums');
    }
}
