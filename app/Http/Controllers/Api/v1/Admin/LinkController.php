<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Http\Controllers\Api\v1\Admin;


use App\Http\Controllers\Api\v1\Controller;
use App\Http\Resources\Link;
use App\Http\Resources\LinkCollection;
use App\Repositories\LinkRepository;
use Illuminate\Http\Request;

/**
 * Class TagController
 * @package App\Http\Controllers\Api\v1
 *
 * @SWG\Tag(name="Admin - Link", description="后台友链")
 */
class LinkController extends Controller
{
    /**
     * @inheritdoc
     */
    public function __construct(LinkRepository $model)
    {
        parent::__construct();
        $this->_model = $model;
    }

    /**
     * 获取友链列表
     *
     * @param Request $request
     * @return array
     *
     * @SWG\Get(path="/admin/links",
     *     tags={"Admin - Link"},
     *     description="获取友链列表",
     *     produces={"application/json"},
     *     security={{"api_key": {}}},
     *     @SWG\Parameter(in="query", name="q", type="string", description="搜索内容 按标题"),
     *     @SWG\Parameter(ref="#/parameters/offsetPageParam"),
     *     @SWG\Parameter(ref="#/parameters/offsetLimitParam"),
     *     @SWG\Response(response=200, description="success",
     *          @SWG\Schema(type="array",
     *              @SWG\Items(ref="#/definitions/linkDefault"),
     *          )
     *     ),
     *     @SWG\Response(response=400,description="failed"),
     *     @SWG\Response(response=401, description="未登录")
     * )
     */
    public function list(Request $request)
    {
        $list = $this->model->paginate($request);
        return $this->resourceInstance(LinkCollection::class, $list)
            ->addMeta($this->model->getMeta($request));
    }

    /**
     * 新增友链
     *
     * @param Request $request
     * @return mixed
     *
     * @SWG\Definition(
     *     definition="linkBodyParams",
     *     type="object",
     *     @SWG\Property(property="name", type="string", description="名称", example="lcckup"),
     *     @SWG\Property(property="icon", type="string", description="icon", example="http://www.lcckup.com/favicon.ico"),
     *     @SWG\Property(property="website", type="string", description="链接", example="http://www.lcckup.com/"),
     *     @SWG\Property(property="summary", type="string", description="名称", example="个人网站"),
     *     @SWG\Property(property="email", type="string", description="名称", example="jindai0305@gmail.com"),
     * )
     *
     * @SWG\Post(path="/admin/link",
     *     tags={"Admin - Link"},
     *     summary="新增友链",
     *     description="新增友链",
     *     security={{"api_key": {}}},
     *     deprecated=false,
     *     @SWG\Parameter(in="body", name="body", description="提交的数据", required=true,
     *         @SWG\Schema(ref="#/definitions/linkBodyParams")
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
     * 修改友链
     *
     * @param $id
     * @param Request $request
     * @return mixed
     *
     * @SWG\Put(path="/admin/link/{id}",
     *     tags={"Admin - Link"},
     *     summary="修改友链",
     *     description="修改友链",
     *     security={{"api_key": {}}},
     *     deprecated=false,
     *     @SWG\Parameter(name="id",type="integer",in="path",description="资源id",required=true,default=1),
     *     @SWG\Parameter(in="body", name="body", description="提交的数据", required=true,
     *         @SWG\Schema(ref="#/definitions/linkBodyParams")
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
     * 删除友链
     *
     * @param $id
     * @return bool|mixed|null
     * @throws \Exception
     *
     * @SWG\Delete(path="/admin/link/{id}",
     *     tags={"Admin - Link"},
     *     summary="删除友链",
     *     description="删除友链",
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
     * 获取友链详情
     *
     * @param $id
     * @return object
     *
     * @SWG\Get(path="/admin/link/{id}",
     *     tags={"Admin - Link"},
     *     summary="获取友链详情",
     *     description="获取一个友链详情",
     *     security={{"api_key": {}}},
     *     deprecated=false,
     *     @SWG\Parameter(name="id",type="integer",in="path",description="资源id",required=true,default=1),
     *     @SWG\Response(response=200,description="success",
     *          @SWG\Schema(ref="#/definitions/linkDefault")
     *     ),
     *     @SWG\Response(response=400,description="failed"),
     *     @SWG\Response(response=401,description="未登录")
     * )
     */
    public function show($id)
    {
        return $this->resourceInstance(Link::class, $this->model->findModel($id));
    }

    /**
     * 上架
     *
     * @param $id
     *
     * @SWG\Put(path="/admin/link/{id}/online",
     *     tags={"Admin - Link"},
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
     * 下架
     *
     * @param $id
     *
     * @SWG\Put(path="/admin/link/{id}/offline",
     *     tags={"Admin - Link"},
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
