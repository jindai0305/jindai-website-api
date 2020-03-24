<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Http\Controllers\Api\v1;


use App\Http\Resources\Comment;
use App\Http\Resources\CommentCollection;
use App\Models\UserRelation;
use App\Repositories\CommentRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class CommentController
 * @package App\Http\Controllers\Api\v1
 *
 * @SWG\Tag(name="Comment", description="评论")
 * @SWG\Tag(name="Admin - Comment", description="后台评论")
 */
class CommentController extends Controller
{
    /**
     * @inheritdoc
     */
    public function __construct(CommentRepository $model)
    {
        parent::__construct();
        $this->_model = $model;
    }

    /**
     * 获取评论列表
     *
     * @param $id
     * @param Request $request
     * @return array
     *
     * @SWG\Get(path="/item/{id}/comments",
     *     tags={"Comment"},
     *     description="获取评论列表",
     *     produces={"application/json"},
     *     @SWG\Parameter(in="path", name="id", type="integer", description="文章id", required=true, default=1),
     *     @SWG\Parameter(ref="#/parameters/offsetPageParam"),
     *     @SWG\Parameter(ref="#/parameters/offsetLimitParam"),
     *     @SWG\Response(response=200, description="success",
     *          @SWG\Schema(type="array",
     *              @SWG\Items(ref="#/definitions/commentIndex"),
     *          )
     *     ),
     *     @SWG\Response(response=400,description="failed"),
     *     @SWG\Response(response=401, description="未登录")
     * )
     */
    public function index($id, Request $request)
    {
        $list = $this->model->paginate($this->offsetRequest($request, [
            'item_id' => $id,
        ]));
        return $this->resourceInstance(CommentCollection::class, $list)
            ->addMeta($this->model->getMeta($request));
    }

    /**
     * 新增
     *
     * @param $id
     * @param Request $request
     * @return mixed
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @SWG\Definition(
     *     definition="commentBodyParams",
     *     type="object",
     *     @SWG\Property(property="content", type="string", description="内容", example="计算机网络"),
     *     @SWG\Property(property="reply_id", type="integer", description="回复的评论id", example=1),
     * )
     *
     * @SWG\Post(path="/item/{id}/comment",
     *     tags={"Comment"},
     *     summary="新增评论",
     *     description="新增评论",
     *     security={{"api_key": {}}},
     *     deprecated=false,
     *     @SWG\Parameter(in="path", name="id", type="integer", description="文章id", required=true, default=1),
     *     @SWG\Parameter(in="body", name="body", description="提交的数据", required=true,
     *         @SWG\Schema(ref="#/definitions/commentBodyParams")
     *     ),
     *     @SWG\Response(response=200,description="success"),
     *     @SWG\Response(response=400,description="failed"),
     *     @SWG\Response(response=401,description="未登录")
     * )
     */
    public function store($id, Request $request)
    {
        $this->authorize('create', \App\Models\Comment::class);
        return $this->resourceInstance(Comment::class, $this->model->store($this->offsetRequest($request, [
            'item_id' => $id
        ])));
    }

    /**
     * 删除
     *
     * @param $id
     * @return bool|mixed|null
     * @throws \Exception
     *
     * @SWG\Delete(path="/comment/{id}",
     *     tags={"Comment"},
     *     summary="删除评论",
     *     description="删除评论",
     *     security={{"api_key": {}}},
     *     deprecated=false,
     *     @SWG\Parameter(name="id",type="integer",in="path",description="资源id",required=true,default=1),
     *     @SWG\Response(response=200,description="success"),
     *     @SWG\Response(response=400,description="failed"),
     *     @SWG\Response(response=401,description="未登录")
     * )
     */
    public function destroy($id)
    {
        $model = $this->model->findModel($id);
        $this->authorize('destroy', $model);
        $model->delete();
    }

    /**
     * 详情
     *
     * @param $id
     * @return object
     *
     * @SWG\Get(path="/comment/{id}",
     *     tags={"Comment"},
     *     summary="获取评论详情",
     *     description="获取一个评论详情",
     *     security={{"api_key": {}}},
     *     deprecated=false,
     *     @SWG\Parameter(name="id",type="integer",in="path",description="资源id",required=true,default=1),
     *     @SWG\Response(response=200,description="success",
     *          @SWG\Schema(ref="#/definitions/commentDefault")
     *     ),
     *     @SWG\Response(response=400,description="failed"),
     *     @SWG\Response(response=401,description="未登录")
     * )
     */
    public function view($id)
    {
        return $this->resourceInstance(Comment::class, $this->model->findModel($id));
    }

    /**
     * 评论点赞事件
     * @param $id
     *
     * @SWG\Put(path="/comment/{id}/approve",
     *     tags={"Comment"},
     *     summary="评论点赞事件",
     *     description="评论点赞事件",
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
                'user_id' => Auth::guard('api')->id(),
                'relation_id' => $model->id,
                'type' => UserRelation::TYPE_COMMENT,
            ]);
        }
        $relation->toggleRelation(UserRelation::FLAG_APPROVE, 'favor');
    }
}
