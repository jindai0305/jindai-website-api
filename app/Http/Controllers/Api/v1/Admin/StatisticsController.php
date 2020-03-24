<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Api\v1\Controller;
use App\Models\Comment;
use App\Models\Item;
use Illuminate\Support\Facades\DB;

/**
 * Class ItemController
 * @package App\Http\Controllers\Api\v1
 *
 * @SWG\Tag(name="Admin - Statistics", description="统计板块")
 */
class StatisticsController extends Controller
{
    /**
     * @return array
     *
     * @SWG\Get(path="/admin/statistics",
     *     tags={"Admin - Statistics"},
     *     description="获取基础统计数据",
     *     produces={"application/json"},
     *     @SWG\Response(response=200, description="success",
     *          @SWG\Schema(type="object",
     *              @SWG\Property(property="name", type="string", description="名称", example="lcckup")
     *          )
     *     ),
     *     @SWG\Response(response=400,description="failed"),
     *     @SWG\Response(response=401, description="未登录")
     * )
     */
    public function index()
    {
        return [
            'item' => $this->fetchItemStatistics(),
            'comment' => $this->fetchCommentStatistics()
        ];
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    protected function fetchItemStatistics()
    {
        return DB::table(Item::tableName())->selectRaw('status, count(id) as num')->groupBy('status')->get();
    }

    /**
     * @return \Illuminate\Support\Collection
     */
    protected function fetchCommentStatistics()
    {
        return DB::table(Comment::tableName())->selectRaw('status, count(id) as num')->groupBy('status')->get();
    }
}
