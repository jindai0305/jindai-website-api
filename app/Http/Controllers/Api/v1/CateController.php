<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Http\Controllers\Api\v1;


use App\Http\Resources\Cate;
use App\Http\Resources\CateCollection;
use App\Repositories\CateRepository;
use Illuminate\Http\Request;

/**
 * Class CateController
 * @package App\Http\Controllers\Api\v1
 *
 * @SWG\Tag(name="Cate", description="分类")
 */
class CateController extends Controller
{
    /**
     * @inheritdoc
     */
    public function __construct(CateRepository $model)
    {
        parent::__construct();
        $this->_model = $model;
    }

    /**
     * 获取分类列表
     *
     * @param Request $request
     * @return \App\Http\Resources\Item|array
     *
     * @SWG\Get(path="/cates",
     *     tags={"Cate"},
     *     description="获取分类列表",
     *     produces={"application/json"},
     *     @SWG\Parameter(in="query", name="q", type="string", description="搜索内容 按标题"),
     *     @SWG\Parameter(ref="#/parameters/offsetPageParam"),
     *     @SWG\Parameter(ref="#/parameters/offsetLimitParam"),
     *     @SWG\Response(response=200, description="success",
     *          @SWG\Schema(type="array",
     *              @SWG\Items(ref="#/definitions/cateIndex"),
     *          )
     *     ),
     *     @SWG\Response(response=400,description="failed"),
     *     @SWG\Response(response=401, description="未登录")
     * )
     */
    public function index(Request $request)
    {
        $list = $this->model->paginate($request);
        return $this->resourceInstance(CateCollection::class, $list)->addMeta($this->model->getMeta($request));
    }
}
