<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Http\Controllers\Api\v1\Admin;


use App\Http\Controllers\Api\v1\Controller;
use App\Http\Resources\Comment;
use App\Http\Resources\CommentCollection;
use App\Repositories\CommentRepository;
use Illuminate\Http\Request;

/**
 * Class CommentController
 * @package App\Http\Controllers\Api\v1
 *
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
     * @param Request $request
     * @return array
     *
     * @SWG\Get(path="/admin/comments",
     *     tags={"Admin - Comment"},
     *     description="获取评论列表",
     *     produces={"application/json"},
     *     security={{"api_key": {}}},
     *     @SWG\Parameter(in="query", name="q", type="string", description="搜索内容 按标题"),
     *     @SWG\Parameter(ref="#/parameters/offsetPageParam"),
     *     @SWG\Parameter(ref="#/parameters/offsetLimitParam"),
     *     @SWG\Response(response=200, description="success",
     *          @SWG\Schema(type="array",
     *              @SWG\Items(ref="#/definitions/commentDefault"),
     *          )
     *     ),
     *     @SWG\Response(response=400,description="failed"),
     *     @SWG\Response(response=401, description="未登录")
     * )
     */
    public function list(Request $request)
    {
        $list = $this->model->paginate($request);
        return $this->resourceInstance(CommentCollection::class, $list)
            ->addMeta($this->model->getMeta($request));
    }

    /**
     * 删除
     *
     * @param $id
     * @return bool|mixed|null
     * @throws \Exception
     *
     * @SWG\Delete(path="/admin/comment/{id}",
     *     tags={"Admin - Comment"},
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
     * 上架
     *
     * @param $id
     *
     * @SWG\Put(path="/admin/comment/{id}/online",
     *     tags={"Admin - Comment"},
     *     summary="上架",
     *     description="上架",
     *     security={{"api_key": {}}},
     *     deprecated=false,
     *     @SWG\Parameter(name="id",type="integer",in="path",description="资源id",required=true,default=1),
     *     @SWG\Response(response=200,description="success"),
     *     @SWG\Response(response=400,description="failed"),
     *     @SWG\Response(response=401,description="未登录")
     * )
     */
    public function online($id)
    {
        $model = $this->model->findModel($id);
        $model->online();
        $model->fireModelEvent('online');
    }

    /**
     * 下架
     *
     * @param $id
     *
     * @SWG\Put(path="/admin/comment/{id}/offline",
     *     tags={"Admin - Comment"},
     *     summary="下架",
     *     description="下架",
     *     security={{"api_key": {}}},
     *     deprecated=false,
     *     @SWG\Parameter(name="id",type="integer",in="path",description="资源id",required=true,default=1),
     *     @SWG\Response(response=200,description="success"),
     *     @SWG\Response(response=400,description="failed"),
     *     @SWG\Response(response=401,description="未登录")
     * )
     */
    public function offline($id)
    {
        $model = $this->model->findModel($id);
        $model->offline();
        $model->fireModelEvent('offline');
    }

    /**
     * 详情
     *
     * @param $id
     * @return object
     *
     * @SWG\Get(path="/admin/comment/{id}",
     *     tags={"Admin - Comment"},
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
    public function show($id)
    {
        return $this->resourceInstance(Comment::class, $this->model->findModel($id));
    }

    /**
     * 修改
     *
     * @param $id
     * @param Request $request
     * @return mixed
     *
     * @SWG\Put(path="/admin/comment/{id}",
     *     tags={"Admin - Comment"},
     *     summary="修改评论",
     *     description="修改评论",
     *     security={{"api_key": {}}},
     *     deprecated=false,
     *     @SWG\Parameter(name="id",type="integer",in="path",description="资源id",required=true,default=1),
     *     @SWG\Parameter(in="body", name="body", description="提交的数据", required=true,
     *         @SWG\Schema(ref="#/definitions/commentBodyParams")
     *     ),
     *     @SWG\Response(response=200,description="success"),
     *     @SWG\Response(response=400,description="failed"),
     *     @SWG\Response(response=401,description="未登录")
     * )
     */
    public function update($id, Request $request)
    {
        $this->model->update($id, $request, false);
    }
}
