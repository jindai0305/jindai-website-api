<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Http\Controllers\Api\v1\Admin;


use App\Http\Controllers\Api\v1\Controller;
use App\Http\Resources\BehaviorLogCollection;
use App\Http\Resources\LoginLogCollection;
use App\Http\Resources\RequestRecordLog;
use App\Http\Resources\RequestRecordLogCollection;
use App\Repositories\BehaviorLogRepository;
use App\Repositories\LoginLogRepository;
use App\Repositories\RequestRecordLogRepository;
use Illuminate\Http\Request;

/**
 * Class LogController
 * @package App\Http\Controllers\Api\v1
 *
 * @SWG\Tag(name="Admin - Logs", description="后台日志记录")
 */
class LogController extends Controller
{
    /**
     * 获取登录记录列表
     *
     * @param Request $request
     * @param LoginLogRepository $model
     * @return array
     *
     * @SWG\Get(path="/admin/login-logs",
     *     tags={"Admin - Logs"},
     *     description="获取登录记录列表",
     *     produces={"application/json"},
     *     security={{"api_key": {}}},
     *     @SWG\Parameter(ref="#/parameters/offsetPageParam"),
     *     @SWG\Parameter(ref="#/parameters/offsetLimitParam"),
     *     @SWG\Response(response=200, description="success",
     *          @SWG\Schema(type="array",
     *              @SWG\Items(ref="#/definitions/loginLogDefault"),
     *          )
     *     ),
     *     @SWG\Response(response=400,description="failed"),
     *     @SWG\Response(response=401, description="未登录")
     * )
     */
    public function loginLog(Request $request, LoginLogRepository $model)
    {
        $list = $model->paginate($request);
        return $this->resourceInstance(LoginLogCollection::class, $list)
            ->addMeta($model->getMeta($request));
    }

    /**
     * 获取行为记录列表
     *
     * @param Request $request
     * @param BehaviorLogRepository $model
     * @return array
     *
     * @SWG\Get(path="/admin/behavior-logs",
     *     tags={"Admin - Logs"},
     *     description="获取行为记录列表",
     *     produces={"application/json"},
     *     security={{"api_key": {}}},
     *     @SWG\Parameter(ref="#/parameters/offsetPageParam"),
     *     @SWG\Parameter(ref="#/parameters/offsetLimitParam"),
     *     @SWG\Response(response=200, description="success",
     *          @SWG\Schema(type="array",
     *              @SWG\Items(ref="#/definitions/behaviorLogDefault"),
     *          )
     *     ),
     *     @SWG\Response(response=400,description="failed"),
     *     @SWG\Response(response=401, description="未登录")
     * )
     */
    public function behaviorLog(Request $request, BehaviorLogRepository $model)
    {
        $list = $model->paginate($request);
        return $this->resourceInstance(BehaviorLogCollection::class, $list)
            ->addMeta($model->getMeta($request));
    }

    /**
     * 获取访问日志
     *
     * @param Request $request
     * @param RequestRecordLogRepository $model
     * @return array
     *
     * @SWG\Get(path="/admin/request-logs",
     *     tags={"Admin - Logs"},
     *     description="获取访问日志",
     *     produces={"application/json"},
     *     security={{"api_key": {}}},
     *     @SWG\Parameter(ref="#/parameters/offsetPageParam"),
     *     @SWG\Parameter(ref="#/parameters/offsetLimitParam"),
     *     @SWG\Parameter(name="user_id",type="integer",in="query",description="用户id"),
     *     @SWG\Response(response=200, description="success",
     *          @SWG\Schema(type="array",
     *              @SWG\Items(ref="#/definitions/requestRecordLogDefault"),
     *          )
     *     ),
     *     @SWG\Response(response=400,description="failed"),
     *     @SWG\Response(response=401, description="未登录")
     * )
     */
    public function requestLog(Request $request, RequestRecordLogRepository $model)
    {
        $list = $model->paginate($request);
        return $this->resourceInstance(RequestRecordLogCollection::class, $list)
            ->addMeta($model->getMeta($request));
    }

    /**
     * 获取访问日志详情
     *
     * @param $id
     * @param RequestRecordLogRepository $model
     * @return object
     *
     * @SWG\Get(path="/admin/request-logs/{id}",
     *     tags={"Admin - Logs"},
     *     summary="获取访问日志详情",
     *     description="获取访问日志详情",
     *     security={{"api_key": {}}},
     *     deprecated=false,
     *     @SWG\Parameter(name="id",type="integer",in="path",description="资源id",required=true,default=1),
     *     @SWG\Response(response=200,description="success",
     *          @SWG\Schema(ref="#/definitions/requestRecordLogView")
     *     ),
     *     @SWG\Response(response=400,description="failed"),
     *     @SWG\Response(response=401,description="未登录")
     * )
     */
    public function requestView($id, RequestRecordLogRepository $model)
    {
        return $this->resourceInstance(RequestRecordLog::class, $model->findModel($id))
            ->setStamp('view');
    }
}
