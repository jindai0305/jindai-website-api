<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Http\Controllers\Api\v1\Admin;


use App\Http\Controllers\Api\v1\Controller;
use App\Http\Resources\Project;
use App\Http\Resources\ProjectCollection;
use App\Repositories\ProjectRepository;
use Illuminate\Http\Request;

/**
 * Class ProjectController
 * @package App\Http\Controllers\Api\v1
 *
 * @SWG\Tag(name="Admin - Project", description="后台项目")
 */
class ProjectController extends Controller
{
    /**
     * @inheritdoc
     */
    public function __construct(ProjectRepository $model)
    {
        parent::__construct();
        $this->_model = $model;
    }

    /**
     * 获取项目列表
     *
     * @param Request $request
     * @return array
     *
     * @SWG\Get(path="/admin/projects",
     *     tags={"Admin - Project"},
     *     description="获取项目列表",
     *     produces={"application/json"},
     *     security={{"api_key": {}}},
     *     @SWG\Parameter(in="query", name="q", type="string", description="搜索内容 按标题"),
     *     @SWG\Parameter(ref="#/parameters/offsetPageParam"),
     *     @SWG\Parameter(ref="#/parameters/offsetLimitParam"),
     *     @SWG\Response(response=200, description="success",
     *          @SWG\Schema(type="array",
     *              @SWG\Items(ref="#/definitions/projectDefault"),
     *          )
     *     ),
     *     @SWG\Response(response=400,description="failed"),
     *     @SWG\Response(response=401, description="未登录")
     * )
     */
    public function list(Request $request)
    {
        $list = $this->model->paginate($request);
        return $this->resourceInstance(ProjectCollection::class, $list)
            ->addMeta($this->model->getMeta($request));
    }

    /**
     * 新增
     *
     * @param Request $request
     * @return mixed
     *
     * @SWG\Definition(
     *     definition="projectBodyParams",
     *     type="object",
     *     @SWG\Property(property="title", type="string", description="标题", example="电商网站"),
     *     @SWG\Property(property="summary", type="string", description="简介", example="电商网站"),
     *     @SWG\Property(property="image", type="string", description="cover-image", example="/path/to/img"),
     *     @SWG\Property(property="github", type="string", description="git地址", example="github.com"),
     *     @SWG\Property(property="website", type="string", description="线上地址", example="http://www.baidu.com"),
     *     @SWG\Property(property="code", type="string", description="二维码", example="/path/to/img"),
     *     @SWG\Property(property="keywords", type="string", description="关键词", example="PHP"),
     *     @SWG\Property(property="start_time", type="integer", description="开始时间", example=1579501412),
     *     @SWG\Property(property="end_time", type="integer", description="结束时间", example=1579501412),
     *     @SWG\Property(property="type", type="integer", description="类型", example=1),
     *     @SWG\Property(property="status", type="integer", description="状态", example=1),
     *     @SWG\Property(property="content", type="integer", description="内容", example="这是个内容")
     * )
     *
     * @SWG\Post(path="/admin/project",
     *     tags={"Admin - Project"},
     *     summary="新增项目",
     *     description="新增项目",
     *     security={{"api_key": {}}},
     *     deprecated=false,
     *     @SWG\Parameter(in="body", name="body", description="提交的数据", required=true,
     *         @SWG\Schema(ref="#/definitions/projectBodyParams")
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
     * @SWG\Put(path="/admin/project/{id}",
     *     tags={"Admin - Project"},
     *     summary="修改项目",
     *     description="修改项目",
     *     security={{"api_key": {}}},
     *     deprecated=false,
     *     @SWG\Parameter(name="id",type="integer",in="path",description="资源id",required=true,default=1),
     *     @SWG\Parameter(in="body", name="body", description="提交的数据", required=true,
     *         @SWG\Schema(ref="#/definitions/projectBodyParams")
     *     ),
     *     @SWG\Response(response=200,description ="success"),
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
     * @SWG\Delete(path="/admin/project/{id}",
     *     tags={"Admin - Project"},
     *     summary="删除项目",
     *     description="删除项目",
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
     * 获取项目详情
     *
     * @param $id
     * @return object
     *
     * @SWG\Get(path="/admin/project/{id}",
     *     tags={"Admin - Project"},
     *     summary="获取项目详情",
     *     description="获取一个项目资源详情",
     *     security={{"api_key": {}}},
     *     deprecated=false,
     *     @SWG\Parameter(name="id",type="integer",in="path",description="资源id",required=true,default=1),
     *     @SWG\Response(response=200,description="success",
     *          @SWG\Schema(ref="#/definitions/projectView")
     *     ),
     *     @SWG\Response(response=400,description="failed"),
     *     @SWG\Response(response=401,description="未登录")
     * )
     */
    public function show($id)
    {
        return $this->resourceInstance(Project::class, $this->model->findModel($id));
    }

    /**
     * 上架
     *
     * @param $id
     *
     * @SWG\Put(path="/admin/project/{id}/online",
     *     tags={"Admin - Project"},
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
     * @SWG\Put(path="/admin/project/{id}/offline",
     *     tags={"Admin - Project"},
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
