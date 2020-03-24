<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Api\v1\Controller;
use App\Http\Resources\Banner;
use App\Http\Resources\BannerCollection;
use App\Repositories\BannerRepository;
use Illuminate\Http\Request;

/**
 * Class BannerController
 * @package App\Http\Controllers\Api\v1
 *
 * @SWG\Tag(name="Admin - Banner", description="后台轮播")
 */
class BannerController extends Controller
{
    /**
     * @inheritdoc
     */
    public function __construct(BannerRepository $model)
    {
        parent::__construct();
        $this->_model = $model;
    }

    /**
     * 获取轮播图列表
     *
     * @param Request $request
     * @return array
     *
     * @SWG\Get(path="/admin/banners",
     *     tags={"Admin - Banner"},
     *     description="获取轮播图列表",
     *     security={{"api_key": {}}},
     *     produces={"application/json"},
     *     @SWG\Response(response=200, description="success",
     *          @SWG\Schema(type="array",
     *              @SWG\Items(ref="#/definitions/bannerDefault"),
     *          )
     *     ),
     *     @SWG\Response(response=400,description="failed"),
     *     @SWG\Response(response=401, description="未登录")
     * )
     */
    public function list(Request $request)
    {
        $list = $this->model->paginate($request);
        return $this->resourceInstance(BannerCollection::class, $list)->addMeta($this->model->getMeta($request));
    }

    /**
     * 新增
     *
     * @param Request $request
     * @return mixed
     *
     * @SWG\Definition(
     *     definition="bannerBodyParams",
     *     type="object",
     *     @SWG\Property(property="title", type="string", description="标题", example="计算机网络"),
     *     @SWG\Property(property="summary", type="string", description="简介", example="计算机网络计算机网络"),
     *     @SWG\Property(property="image", type="string", description="图片链接", example="https://www.w3school.com.cn//i/eg_tulip.jpg"),
     *     @SWG\Property(property="url", type="string", description="跳转链接", example="https://www.lcckup.com"),
     *     @SWG\Property(property="status", type="integer", description="状态 0:隐藏 1:显示", example=1),
     * )
     *
     * @SWG\Post(path="/admin/banner",
     *     tags={"Admin - Banner"},
     *     summary="新增轮播图",
     *     description="新增轮播图",
     *     security={{"api_key": {}}},
     *     deprecated=false,
     *     @SWG\Parameter(in="body", name="body", description="提交的数据", required=true,
     *         @SWG\Schema(ref="#/definitions/bannerBodyParams")
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
     * @SWG\Put(path="/admin/banner/{id}",
     *     tags={"Admin - Banner"},
     *     summary="修改轮播图",
     *     description="修改轮播图",
     *     security={{"api_key": {}}},
     *     deprecated=false,
     *     @SWG\Parameter(name="id",type="integer",in="path",description="资源id",required=true,default=1),
     *     @SWG\Parameter(in="body", name="body", description="提交的数据", required=true,
     *         @SWG\Schema(ref="#/definitions/bannerBodyParams")
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
     * @SWG\Delete(path="/admin/banner/{id}",
     *     tags={"Admin - Banner"},
     *     summary="删除轮播图",
     *     description="删除轮播图",
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
     * 详情
     *
     * @param $id
     * @return object
     *
     * @SWG\Get(path="/admin/banner/{id}",
     *     tags={"Admin - Banner"},
     *     summary="获取轮播图详情",
     *     description="获取轮播图详情",
     *     security={{"api_key": {}}},
     *     deprecated=false,
     *     @SWG\Parameter(name="id",type="integer",in="path",description="资源id",required=true,default=1),
     *     @SWG\Response(response=200,description="success",
     *          @SWG\Schema(ref="#/definitions/bannerDefault")
     *     ),
     *     @SWG\Response(response=400,description="failed"),
     *     @SWG\Response(response=401,description="未登录")
     * )
     */
    public function show($id)
    {
        return $this->resourceInstance(Banner::class, $this->model->findModel($id))
            ->setStamp('view');
    }

    /**
     * 上架
     *
     * @param $id
     *
     * @SWG\Put(path="/admin/banner/{id}/online",
     *     tags={"Admin - Banner"},
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
     * @SWG\Put(path="/admin/banner/{id}/offline",
     *     tags={"Admin - Banner"},
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
