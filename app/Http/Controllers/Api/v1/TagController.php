<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Http\Controllers\Api\v1;


use App\Http\Resources\Tag;
use App\Http\Resources\TagCollection;
use App\Repositories\TagRepository;
use Illuminate\Http\Request;

/**
 * Class TagController
 * @package App\Http\Controllers\Api\v1
 *
 * @SWG\Tag(name="Tag", description="标签")
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
     * @SWG\Get(path="/tags",
     *     tags={"Tag"},
     *     description="获取标签列表",
     *     produces={"application/json"},
     *     @SWG\Parameter(in="query", name="q", type="string", description="搜索内容 按标题"),
     *     @SWG\Parameter(ref="#/parameters/offsetPageParam"),
     *     @SWG\Parameter(ref="#/parameters/offsetLimitParam"),
     *     @SWG\Response(response=200, description="success",
     *          @SWG\Schema(type="array",
     *              @SWG\Items(ref="#/definitions/tagIndex"),
     *          )
     *     ),
     *     @SWG\Response(response=400,description="failed"),
     *     @SWG\Response(response=401, description="未登录")
     * )
     */
    public function index(Request $request)
    {
        $list = $this->model->paginate($request);
        return $this->resourceInstance(TagCollection::class, $list)
            ->addMeta($this->model->getMeta($request));
    }
}
