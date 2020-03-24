<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Api\v1\Controller;
use App\Http\Resources\User;
use App\Http\Resources\UserCollection;
use App\Repositories\UserRepository;
use Illuminate\Http\Request;

/**
 * Class UserController
 * @package App\Http\Controllers\Api\v1
 *
 * @SWG\Tag(name="Admin - User", description="后台用户")
 */
class UserController extends Controller
{
    /**
     * @inheritdoc
     */
    public function __construct(UserRepository $model)
    {
        parent::__construct();
        $this->_model = $model;
    }

    /**
     * 获取用户列表
     *
     * @param Request $request
     * @return array
     *
     * @SWG\Get(path="/admin/users",
     *     tags={"Admin - User"},
     *     description="获取用户列表",
     *     produces={"application/json"},
     *     security={{"api_key": {}}},
     *     @SWG\Parameter(in="query", name="q", type="string", description="搜索内容 按标题"),
     *     @SWG\Parameter(ref="#/parameters/offsetPageParam"),
     *     @SWG\Parameter(ref="#/parameters/offsetLimitParam"),
     *     @SWG\Response(response=200, description="success",
     *          @SWG\Schema(type="array",
     *              @SWG\Items(ref="#/definitions/userDefault"),
     *          )
     *     ),
     *     @SWG\Response(response=400,description="failed"),
     *     @SWG\Response(response=401, description="未登录")
     * )
     */
    public function list(Request $request)
    {
        $list = $this->model->paginate($request);
        return $this->resourceInstance(UserCollection::class, $list)
            ->addMeta($this->model->getMeta($request));
    }

    /**
     * 详情
     *
     * @param $id
     * @return object
     *
     * @SWG\Get(path="/admin/user/{id}",
     *     tags={"Admin - User"},
     *     summary="获取用户详情",
     *     description="获取用户详情",
     *     security={{"api_key": {}}},
     *     deprecated=false,
     *     @SWG\Parameter(name="id",type="integer",in="path",description="资源id",required=true,default=1),
     *     @SWG\Response(response=200,description="success",
     *          @SWG\Schema(ref="#/definitions/userDefault")
     *     ),
     *     @SWG\Response(response=400,description="failed"),
     *     @SWG\Response(response=401,description="未登录")
     * )
     */
    public function show($id)
    {
        return $this->resourceInstance(User::class, $this->model->findModel($id));
    }

    /**
     * 新增
     *
     * @param Request $request
     * @return mixed
     *
     * @SWG\Definition(
     *     definition="userBodyParams",
     *     type="object",
     *     @SWG\Property(property="name", type="string", description="名称", example="name"),
     *     @SWG\Property(property="email", type="string", description="名称", example="email@163.com"),
     *     @SWG\Property(property="nick_name", type="string", description="名称", example="昵称"),
     *     @SWG\Property(property="avatar", type="object", description="头像",
     *          @SWG\Property(property="id", type="integer", description="id", example=1),
     *          @SWG\Property(property="url", type="string", description="链接", example="https://cube.elemecdn.com/3/7c/3ea6beec64369c2642b92c6726f1epng.png"),
     *     ),
     *     @SWG\Property(property="website", type="string", description="个人网址", example="http://www.baidu.com"),
     *     @SWG\Property(property="signature", type="string", description="个人简介", example="这是个人简介"),
     *     @SWG\Property(property="is_admin", type="boolean", description="是否管理员", example=true),
     * )
     *
     * @SWG\Post(path="/admin/user",
     *     tags={"Admin - User"},
     *     summary="新增用户",
     *     description="新增用户",
     *     security={{"api_key": {}}},
     *     deprecated=false,
     *     @SWG\Parameter(in="body", name="body", description="提交的数据", required=true,
     *         @SWG\Schema(ref="#/definitions/userBodyParams")
     *     ),
     *     @SWG\Response(response=200,description="success"),
     *     @SWG\Response(response=400,description="failed"),
     *     @SWG\Response(response=401,description="未登录")
     * )
     */
    public function store(Request $request)
    {
        /** @var \App\Models\User $model */
        $model = $this->model->store($request);
        $model->fullUserExpand($request);
    }

    /**
     * 修改
     *
     * @param $id
     * @param Request $request
     * @return mixed
     *
     * @SWG\Put(path="/admin/user/{id}",
     *     tags={"Admin - User"},
     *     summary="修改用户",
     *     description="修改用户",
     *     security={{"api_key": {}}},
     *     deprecated=false,
     *     @SWG\Parameter(name="id",type="integer",in="path",description="资源id",required=true,default=1),
     *     @SWG\Parameter(in="body", name="body", description="提交的数据", required=true,
     *         @SWG\Schema(ref="#/definitions/userBodyParams")
     *     ),
     *     @SWG\Response(response=200,description="success"),
     *     @SWG\Response(response=400,description="failed"),
     *     @SWG\Response(response=401,description="未登录")
     * )
     */
    public function update($id, Request $request)
    {
        /** @var \App\Models\User $model */
        $model = $this->model->update($id, $request);
        $model->fullUserExpand($request);
    }

    /**
     * 权限设置
     *
     * @param $id
     * @param Request $request
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @SWG\Put(path="/admin/user/{id}/authority",
     *     tags={"Admin - User"},
     *     description="权限设置",
     *     produces={"application/json"},
     *     security={{"api_key": {}}},
     *     @SWG\Parameter(in="path", name="id", type="integer", description="id", required=true),
     *     @SWG\Parameter(in="body", name="body", description="提交的数据", required=true,
     *         @SWG\Schema(
     *             @SWG\Property(property="action", type="string", description="执行函数 moveBlack:拉黑 removeBlack:取消拉黑 muted:禁言 removeMuted:取消禁言", example="moveBlack"),
     *         )
     *     ),
     *     @SWG\Response(response=200, description="success"),
     *     @SWG\Response(response=400,description="failed"),
     *     @SWG\Response(response=401, description="未登录")
     * )
     */
    public function authority($id, Request $request)
    {
        if (!$action = $request->get('action', false)) {
            return;
        }
        // 权限
        if ($permissionAction = \App\Models\User::permissionAction()) {
            if (in_array($action, array_keys($permissionAction))) {
                $this->authorize($permissionAction[$action], $this->user);
            }
        }
        /** @var \App\Models\User $model */
        $model = $this->model->findModel($id);
        if (!is_callable([$model, $action])) {
            abort(403, 'Permission denied');
        }
        call_user_func([$model, $action]);
    }

    /**
     * 重置密码
     *
     * @param $id
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @SWG\Put(path="/admin/user/{id}/reset-password",
     *     tags={"Admin - User"},
     *     description="重置密码",
     *     produces={"application/json"},
     *     security={{"api_key": {}}},
     *     @SWG\Parameter(in="path", name="id", type="integer", description="id", required=true),
     *     @SWG\Response(response=200, description="success"),
     *     @SWG\Response(response=400,description="failed"),
     *     @SWG\Response(response=401, description="未登录")
     * )
     */
    public function resetPassword($id)
    {
        $this->authorize('super', $this->user);
        /** @var \App\Models\User $model */
        $model = $this->model->findModel($id);
        $model->password = $model->name . '123456';
        $model->save();
    }

    /**
     * 失效token
     *
     * @param $id
     * @throws \Illuminate\Auth\Access\AuthorizationException
     *
     * @SWG\Put(path="/admin/user/{id}/invalid-token",
     *     tags={"Admin - User"},
     *     description="失效token",
     *     produces={"application/json"},
     *     security={{"api_key": {}}},
     *     @SWG\Parameter(in="path", name="id", type="integer", description="id", required=true),
     *     @SWG\Response(response=200, description="success"),
     *     @SWG\Response(response=400,description="failed"),
     *     @SWG\Response(response=401, description="未登录")
     * )
     */
    public function invalidToken($id)
    {
        $this->authorize('super', $this->user);
        /** @var \App\Models\User $model */
        $model = $this->model->findModel($id);
        $model->invalidToken();
    }
}
