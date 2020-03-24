<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Http\Controllers\Api\v1;

use App\Http\Resources\Banner;
use App\Http\Resources\BannerCollection;
use App\Repositories\BannerRepository;
use Illuminate\Http\Request;

/**
 * Class BannerController
 * @package App\Http\Controllers\Api\v1
 *
 * @SWG\Tag(name="Banner", description="轮播")
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
     * @return \App\Http\Resources\Item|array
     *
     * @SWG\Get(path="/banners",
     *     tags={"Banner"},
     *     description="获取轮播图列表",
     *     produces={"application/json"},
     *     @SWG\Parameter(in="query", name="q", type="string", description="搜索内容 按标题"),
     *     @SWG\Parameter(ref="#/parameters/offsetPageParam"),
     *     @SWG\Parameter(ref="#/parameters/offsetLimitParam"),
     *     @SWG\Response(response=200, description="success",
     *          @SWG\Schema(type="array",
     *              @SWG\Items(ref="#/definitions/bannerIndex"),
     *          )
     *     ),
     *     @SWG\Response(response=400,description="failed"),
     *     @SWG\Response(response=401, description="未登录")
     * )
     */
    public function index(Request $request)
    {
        $list = $this->model->paginate($request);
        return $this->resourceInstance(BannerCollection::class, $list)
            ->addMeta($this->model->getMeta($request))
            ->setStamp('index');
    }
}
