<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Http\Controllers\Api\v1;


use App\Http\Resources\Link;
use App\Http\Resources\LinkCollection;
use App\Repositories\LinkRepository;
use Illuminate\Http\Request;

/**
 * Class TagController
 * @package App\Http\Controllers\Api\v1
 *
 * @SWG\Tag(name="Link", description="友链")
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
     * @SWG\Get(path="/links",
     *     tags={"Link"},
     *     description="获取友链列表",
     *     produces={"application/json"},
     *     @SWG\Parameter(in="query", name="q", type="string", description="搜索内容 按标题"),
     *     @SWG\Parameter(ref="#/parameters/offsetPageParam"),
     *     @SWG\Parameter(ref="#/parameters/offsetLimitParam"),
     *     @SWG\Response(response=200, description="success",
     *          @SWG\Schema(type="array",
     *              @SWG\Items(ref="#/definitions/linkIndex"),
     *          )
     *     ),
     *     @SWG\Response(response=400,description="failed"),
     *     @SWG\Response(response=401, description="未登录")
     * )
     */
    public function index(Request $request)
    {
        $list = $this->model->paginate($request);
        return $this->resourceInstance(LinkCollection::class, $list)
            ->addMeta($this->model->getMeta($request));
    }
}
