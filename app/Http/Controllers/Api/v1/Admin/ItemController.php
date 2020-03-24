<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Http\Controllers\Api\v1\Admin;


use App\Http\Controllers\Api\v1\Controller;
use App\Http\Resources\Item;
use App\Http\Resources\ItemCollection;
use App\Jobs\CoverAboutMeHtml;
use App\Models\UserRelation;
use App\Repositories\ItemRepository;
use Illuminate\Http\Request;

/**
 * Class ItemController
 * @package App\Http\Controllers\Api\v1\Admin
 *
 * @SWG\Tag(name="Admin - Item", description="后台文章")
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
     * @return Item|array
     *
     * @SWG\Get(path="/admin/items",
     *     tags={"Admin - Item"},
     *     description="获取文章列表",
     *     produces={"application/json"},
     *     security={{"api_key": {}}},
     *     @SWG\Parameter(in="query", name="q", type="string", description="搜索内容 按标题"),
     *     @SWG\Parameter(ref="#/parameters/offsetPageParam"),
     *     @SWG\Parameter(ref="#/parameters/offsetLimitParam"),
     *     @SWG\Response(response=200, description="success",
     *          @SWG\Schema(type="array",
     *              @SWG\Items(ref="#/definitions/itemDefault"),
     *          )
     *     ),
     *     @SWG\Response(response=400,description="failed"),
     *     @SWG\Response(response=401, description="未登录")
     * )
     */
    public function list(Request $request)
    {
        $list = $this->model->paginate($request);
        return $this->resourceInstance(ItemCollection::class, $list)
            ->addMeta($this->model->getMeta($request));
    }

    /**
     * 新增
     *
     * @param Request $request
     * @return mixed
     *
     * @SWG\Definition(
     *     definition="itemBodyParams",
     *     type="object",
     *     @SWG\Property(property="title", type="string", description="标题", example="计算机网络"),
     *     @SWG\Property(property="cate_id", type="integer", description="分类id", example=1),
     *     @SWG\Property(property="tag_list", type="array", description="标签组",
     *          @SWG\Items(type="integer", example=1)
     *     ),
     *     @SWG\Property(property="summary", type="string", description="简介", example="这是一个简介"),
     *     @SWG\Property(property="image", type="string", description="图片", example="文章缩略图"),
     *     @SWG\Property(property="content", type="string", description="内容", example="内容"),
     *     @SWG\Property(property="chosen", type="boolean", description="是否精选", example=true),
     *     @SWG\Property(property="type", type="integer", description="类型 0：默认 1：markdown", example=1),
     *     @SWG\Property(property="allow_comment", type="boolean", description="能否评论", example=true),
     *     @SWG\Property(property="copyright", type="integer", description="版权 1原创 2转载", example=1),
     *     @SWG\Property(property="original_link", type="string", description="原链接", example="https://www.baidu.com"),
     * )
     *
     * @SWG\Post(path="/admin/item",
     *     tags={"Admin - Item"},
     *     summary="新增文章",
     *     description="新增文章",
     *     security={{"api_key": {}}},
     *     deprecated=false,
     *     @SWG\Parameter(in="body", name="body", description="提交的数据", required=true,
     *         @SWG\Schema(ref="#/definitions/itemBodyParams")
     *     ),
     *     @SWG\Response(response=200,description="success"),
     *     @SWG\Response(response=400,description="failed"),
     *     @SWG\Response(response=401,description="未登录")
     * )
     */
    public function store(Request $request)
    {
        /** @var \App\Models\Item $model */
        $model = $this->model->store($request);
        $model->tags()->sync($request->get('tag_list', []));
    }

    /**
     * 修改
     *
     * @param $id
     * @param Request $request
     * @return mixed
     *
     * @SWG\Put(path="/admin/item/{id}",
     *     tags={"Admin - Item"},
     *     summary="修改文章",
     *     description="修改文章",
     *     security={{"api_key": {}}},
     *     deprecated=false,
     *     @SWG\Parameter(name="id",type="integer",in="path",description="资源id",required=true,default=1),
     *     @SWG\Parameter(in="body", name="body", description="提交的数据", required=true,
     *         @SWG\Schema(ref="#/definitions/itemBodyParams")
     *     ),
     *     @SWG\Response(response=200,description="success"),
     *     @SWG\Response(response=400,description="failed"),
     *     @SWG\Response(response=401,description="未登录")
     * )
     */
    public function update($id, Request $request)
    {
        $model = $this->model->update($id, $request);
        $model->tags()->sync($request->get('tag_list', []));
    }

    /**
     * 删除
     *
     * @param $id
     * @return bool|mixed|null
     * @throws \Exception
     *
     * @SWG\Delete(path="/admin/item/{id}",
     *     tags={"Admin - Item"},
     *     summary="删除分类",
     *     description="删除分类",
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
     * @SWG\Get(path="/admin/item/{id}",
     *     tags={"Admin - Item"},
     *     summary="获取文章详情",
     *     description="获取文章详情",
     *     security={{"api_key": {}}},
     *     deprecated=false,
     *     @SWG\Parameter(name="id",type="integer",in="path",description="资源id",required=true,default=1),
     *     @SWG\Response(response=200,description="success",
     *          @SWG\Schema(ref="#/definitions/itemEdit")
     *     ),
     *     @SWG\Response(response=400,description="failed"),
     *     @SWG\Response(response=401,description="未登录")
     * )
     */
    public function show($id)
    {
        return $this->resourceInstance(Item::class, $this->model->findModel($id))
            ->setStamp('edit');
    }

    /**
     * 上架
     *
     * @param $id
     *
     * @SWG\Put(path="/admin/item/{id}/online",
     *     tags={"Admin - Item"},
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
     * @SWG\Put(path="/admin/item/{id}/offline",
     *     tags={"Admin - Item"},
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

    /**
     * 设置为关于我
     *
     * @param $id
     *
     * @SWG\Put(path="/admin/item/{id}/about",
     *     tags={"Admin - Item"},
     *     summary="设置为关于我",
     *     description="设置为关于我",
     *     security={{"api_key": {}}},
     *     deprecated=false,
     *     @SWG\Parameter(name="id",type="integer",in="path",description="资源id",required=true,default=1),
     *     @SWG\Response(response=200,description="success"),
     *     @SWG\Response(response=400,description="failed"),
     *     @SWG\Response(response=401,description="未登录")
     * )
     */
    public function about($id)
    {
        /** @var \App\Models\Item $model */
        $model = $this->model->findModel($id);
        dispatch_now(new CoverAboutMeHtml($model));
    }
}
