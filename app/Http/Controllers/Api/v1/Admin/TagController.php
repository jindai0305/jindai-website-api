<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Http\Controllers\Api\v1\Admin;


use App\Http\Controllers\Api\v1\Controller;
use App\Http\Resources\Tag;
use App\Http\Resources\TagCollection;
use App\Repositories\TagRepository;
use Illuminate\Http\Request;

/**
 * Class TagController
 * @package App\Http\Controllers\Api\v1
 *
 * @SWG\Tag(name="Admin - Tag", description="后台标签")
 */
class TagController extends Controller
{
    /**
     * @inheritdoc
     */
    public function __construct(TagRepository $model)
    {
        parent::__construct();
        $this->_model = $model;
    }

    /**
     * 获取标签列表
     *
     * @param Request $request
     * @return array
     *
     * @SWG\Get(path="/admin/tags",
     *     tags={"Admin - Tag"},
     *     description="获取标签列表",
     *     produces={"application/json"},
     *     security={{"api_key": {}}},
     *     @SWG\Parameter(in="query", name="q", type="string", description="搜索内容 按标题"),
     *     @SWG\Parameter(ref="#/parameters/offsetPageParam"),
     *     @SWG\Parameter(ref="#/parameters/offsetLimitParam"),
     *     @SWG\Response(response=200, description="success",
     *          @SWG\Schema(type="array",
     *              @SWG\Items(ref="#/definitions/cateDefault"),
     *          )
     *     ),
     *     @SWG\Response(response=400,description="failed"),
     *     @SWG\Response(response=401, description="未登录")
     * )
     */
    public function list(Request $request)
    {
        $list = $this->model->paginate($request);
        return $this->resourceInstance(TagCollection::class, $list)
            ->addMeta($this->model->getMeta($request));
    }

    /**
     * 新增
     *
     * @param Request $request
     * @return mixed
     *
     * @SWG\Definition(
     *     definition="tagBodyParams",
     *     type="object",
     *     @SWG\Property(property="name", type="string", description="名称", example="计算机网络"),
     * )
     *
     * @SWG\Post(path="/admin/tag",
     *     tags={"Admin - Tag"},
     *     summary="新增标签",
     *     description="新增标签",
     *     security={{"api_key": {}}},
     *     deprecated=false,
     *     @SWG\Parameter(in="body", name="body", description="提交的数据", required=true,
     *         @SWG\Schema(ref="#/definitions/tagBodyParams")
     *     ),
     *     @SWG\Response(response=200,description="success"),
     *     @SWG\Response(response=400,description="failed"),
     *     @SWG\Response(response=401,description="未登录")
     * )
     */
    public function store(Request $request)
    {
        return $this->model->store($request);
    }

    /**
     * 修改
     *
     * @param $id
     * @param Request $request
     * @return mixed
     *
     * @SWG\Put(path="/admin/tag/{id}",
     *     tags={"Admin - Tag"},
     *     summary="修改标签",
     *     description="修改标签",
     *     security={{"api_key": {}}},
     *     deprecated=false,
     *     @SWG\Parameter(name="id",type="integer",in="path",description="资源id",required=true,default=1),
     *     @SWG\Parameter(in="body", name="body", description="提交的数据", required=true,
     *         @SWG\Schema(ref="#/definitions/tagBodyParams")
     *     ),
     *     @SWG\Response(response=200,description="success"),
     *     @SWG\Response(response=400,description="failed"),
     *     @SWG\Response(response=401,description="未登录")
     * )
     */
    public function update($id, Request $request)
    {
        return $this->model->update($id, $request);
    }

    /**
     * 删除
     *
     * @param $id
     * @return bool|mixed|null
     * @throws \Exception
     *
     * @SWG\Delete(path="/admin/tag/{id}",
     *     tags={"Admin - Tag"},
     *     summary="删除标签",
     *     description="删除标签",
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
        $this->model->destroy($id);
    }

    /**
     * 获取标签详情
     *
     * @param $id
     * @return object
     *
     * @SWG\Get(path="/admin/tag/{id}",
     *     tags={"Admin - Tag"},
     *     summary="获取标签详情",
     *     description="获取一个标签资源详情",
     *     security={{"api_key": {}}},
     *     deprecated=false,
     *     @SWG\Parameter(name="id",type="integer",in="path",description="资源id",required=true,default=1),
     *     @SWG\Response(response=200,description="success",
     *          @SWG\Schema(ref="#/definitions/tagDefault")
     *     ),
     *     @SWG\Response(response=400,description="failed"),
     *     @SWG\Response(response=401,description="未登录")
     * )
     */
    public function show($id)
    {
        return $this->resourceInstance(Tag::class, $this->model->findModel($id));
    }

    /**
     * 上架
     *
     * @param $id
     *
     * @SWG\Put(path="/admin/tag/{id}/online",
     *     tags={"Admin - Tag"},
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
    }

    /**
     * 上架
     *
     * @param $id
     *
     * @SWG\Put(path="/admin/tag/{id}/offline",
     *     tags={"Admin - Tag"},
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
    }
}
