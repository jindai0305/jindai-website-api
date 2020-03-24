<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Http\Controllers\Api\v1;

use App\Repositories\UserRepository;
use Illuminate\Http\Request;
use App\Support\Token;

/**
 * Class TokenController
 * @package App\Http\Controllers\Api\v1
 *
 * @SWG\Tag(name="Token", description="登录|授权相关")
 */
class TokenController extends Controller
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
     * 注册
     *
     * @param Request $request
     * @param Token $token
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @SWG\Post(path="/register",
     *     tags={"Token"},
     *     description="注册",
     *     produces={"application/json"},
     *     @SWG\Parameter(in="body", name="body", description="提交的数据", required=true,
     *         @SWG\Schema(
     *              @SWG\Property(property="name", type="string", description="账号", example="jindai"),
     *              @SWG\Property(property="email", type="string", description="邮箱", example="jindai0305@gmail.com"),
     *              @SWG\Property(property="password", type="string", description="密码", example="jindai"),
     *              @SWG\Property(property="password_confirm", type="string", description="密码重复", example="jindai")
     *         )
     *     ),
     *     @SWG\Response(response=200, description="success",
     *          @SWG\Schema(ref="#/definitions/userIndex")
     *     ),
     *     @SWG\Response(response=400,description="failed"),
     *     @SWG\Response(response=401, description="未登录")
     * )
     */
    public function register(Request $request, Token $token)
    {
        /** @var \App\Models\User $model */
        $model = $this->model->store($request);
        $model->fullUserExpand($request);

        return $token->createToken($request->get('email', false), $request->get('password', false));
    }

    /**
     * 登录
     *
     * @param Request $request
     * @param Token $token
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @throws \Illuminate\Validation\ValidationException
     *
     * @SWG\Post(path="/token",
     *     tags={"Token"},
     *     description="登录",
     *     produces={"application/json"},
     *     @SWG\Parameter(in="body", name="body", description="提交的数据", required=true,
     *         @SWG\Schema(
     *              @SWG\Property(property="account", type="string", description="账号", example="jindai"),
     *              @SWG\Property(property="password", type="string", description="密码", example="jindai")
     *         )
     *     ),
     *     @SWG\Response(response=200, description="success"),
     *     @SWG\Response(response=400,description="failed"),
     *     @SWG\Response(response=401, description="未登录")
     * )
     */
    public function token(Request $request, Token $token)
    {
        $this->validate($request, [
            'account' => 'required',
            'password' => 'required',
        ]);
        return $token->createToken($request->get('account', false), $request->get('password', false));
    }

    /**
     * 刷新令牌
     *
     * @param Request $request
     * @param Token $token
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     *
     * @SWG\Post(path="/refresh-token",
     *     tags={"Token"},
     *     description="刷新令牌",
     *     produces={"application/json"},
     *     @SWG\Parameter(in="body", name="body", description="提交的数据", required=true,
     *         @SWG\Schema(
     *              @SWG\Property(property="refresh_token", type="string", description="刷新令牌", example="token"),
     *         )
     *     ),
     *     @SWG\Response(response=200, description="success"),
     *     @SWG\Response(response=400,description="failed"),
     *     @SWG\Response(response=401, description="未登录")
     * )
     */
    public function refreshToken(Request $request, Token $token)
    {
        if (!$request->has('refresh_token')) {
            abort(401, 'Unauthenticated');
        }
        return $token->refreshToken($request->get('refresh_token'));
    }
}
