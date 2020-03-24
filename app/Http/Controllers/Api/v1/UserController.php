<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Http\Controllers\Api\v1;

use App\Http\Resources\User;
use App\Repositories\UserRepository;
use App\Support\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class UserController
 * @package App\Http\Controllers\Api\v1
 *
 * @SWG\Tag(name="User", description="用户")
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
     * 用户信息
     * @return object
     *
     * @SWG\Get(path="/user/profile",
     *     tags={"User"},
     *     description="获取用户信息",
     *     produces={"application/json"},
     *     security={{"api_key": {}}},
     *     @SWG\Response(response=200, description="success",
     *          @SWG\Schema(ref="#/definitions/userIndex")
     *     ),
     *     @SWG\Response(response=400,description="failed"),
     *     @SWG\Response(response=401, description="未登录")
     * )
     */
    public function profile()
    {
        return $this->resourceInstance(User::class, $this->user);
    }

    /**
     * 退出登录
     *
     * @param Token $token
     * @return string
     *
     * @SWG\Get(path="/user/login-out",
     *     tags={"User"},
     *     description="退出登录",
     *     produces={"application/json"},
     *     security={{"api_key": {}}},
     *     @SWG\Response(response=200, description="success"),
     *     @SWG\Response(response=400,description="failed"),
     *     @SWG\Response(response=401, description="未登录")
     * )
     */
    public function loginOut(Token $token)
    {
        if (Auth::guard('api')->check()) {
            Auth::guard('api')->user()->token()->delete();
        }
        $token->loginOut();

        return 'success';
    }
}
