<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Http\Controllers\Api\v1\Admin;

use App\Http\Controllers\Api\v1\Controller;
use App\Http\Resources\Setting;
use App\Repositories\SettingRepository;
use Illuminate\Http\Request;

/**
 * Class SettingController
 * @package App\Http\Controllers\Api\v1
 *
 * @SWG\Tag(name="Admin - Setting", description="后台设置")
 */
class SettingController extends Controller
{
    /**
     * @inheritdoc
     */
    public function __construct(SettingRepository $model)
    {
        parent::__construct();
        $this->_model = $model;
    }

    /**
     * 获取各类设置
     *
     * @param string $type
     * @return array
     *
     * @SWG\Get(path="/admin/setting/{type}",
     *     tags={"Admin - Setting"},
     *     description="获取各类设置",
     *     produces={"application/json"},
     *     @SWG\Parameter(in="path", name="type", type="string", description="basis／ module/ personal/ about", enum={"basis","module","personal","about"}, required=true),
     *     @SWG\Response(response=200, description="success",
     *          @SWG\Schema(ref="#/definitions/settingDefault")
     *     ),
     *     @SWG\Response(response=400,description="failed"),
     *     @SWG\Response(response=401, description="未登录")
     * )
     */
    public function view($type)
    {
        if (!in_array($type, ['basis', 'module', 'personal', 'about'])) {
            abort(400, '参数错误！' . '不存在`' . $type . '`配置');
        }
        return $this->resourceInstance(Setting::class, $this->model->findModel(config('website.setting.id')))
            ->setStamp($type);
    }

    /**
     * 修改基本设置
     * @param Request $request
     * @return \App\Http\Resources\Setting|array|object
     *
     * @SWG\Put(path="/admin/setting/basis",
     *     tags={"Admin - Setting"},
     *     summary="修改基本设置",
     *     description="修改基本设置",
     *     security={{"api_key": {}}},
     *     deprecated=false,
     *     @SWG\Parameter(in="body", name="body", description="提交的数据", required=true,
     *         @SWG\Schema(ref="#/definitions/settingBasis")
     *     ),
     *     @SWG\Response(response=200,description="success"),
     *     @SWG\Response(response=400,description="failed"),
     *     @SWG\Response(response=401,description="未登录")
     * )
     */
    public function basis(Request $request)
    {
        $model = $this->model->findModel(config('website.setting.id'));

        $model->fill($request->only(['title', 'description', 'keywords', 'logo', 'repair', 'record', 'record_url']));
        $model->save();

        return $this->resourceInstance(Setting::class, $model)
            ->setStamp('basis');
    }

    /**
     * 修改模块设置
     * @param Request $request
     * @return \App\Http\Resources\Setting|array|object
     *
     * @SWG\Put(path="/admin/setting/module",
     *     tags={"Admin - Setting"},
     *     summary="修改模块设置",
     *     description="修改模块设置",
     *     security={{"api_key": {}}},
     *     deprecated=false,
     *     @SWG\Parameter(in="body", name="body", description="提交的数据", required=true,
     *         @SWG\Schema(ref="#/definitions/settingModule")
     *     ),
     *     @SWG\Response(response=200,description="success"),
     *     @SWG\Response(response=400,description="failed"),
     *     @SWG\Response(response=401,description="未登录")
     * )
     */
    public function module(Request $request)
    {
        $model = $this->model->findModel(config('website.setting.id'));

        $model->fill($request->only(['message', 'comment', 'chat', 'reward', 'alipay', 'wechat']));
        $model->save();

        return $this->resourceInstance(Setting::class, $model)
            ->setStamp('module');
    }

    /**
     * 修改个人设置
     * @param Request $request
     * @return \App\Http\Resources\Setting|array|object
     *
     * @SWG\Put(path="/admin/setting/personal",
     *     tags={"Admin - Setting"},
     *     summary="修改基本设置",
     *     description="修改基本设置",
     *     security={{"api_key": {}}},
     *     deprecated=false,
     *     @SWG\Parameter(in="body", name="body", description="提交的数据", required=true,
     *         @SWG\Schema(ref="#/definitions/settingPersonal")
     *     ),
     *     @SWG\Response(response=200,description="success"),
     *     @SWG\Response(response=400,description="failed"),
     *     @SWG\Response(response=401,description="未登录")
     * )
     */
    public function personal(Request $request)
    {
        $model = $this->model->findModel(config('website.setting.id'));

        $model->fill($request->only(['nick_name', 'signature', 'avatar', 'contact', 'visibility']));
        $model->save();

        return $this->resourceInstance(Setting::class, $model)
            ->setStamp('personal');
    }

    /**
     * 修改关于我
     * @param Request $request
     * @return \App\Http\Resources\Setting|array|object
     *
     * @SWG\Put(path="/admin/setting/about",
     *     tags={"Admin - Setting"},
     *     summary="修改关于我",
     *     description="修改关于我",
     *     security={{"api_key": {}}},
     *     deprecated=false,
     *     @SWG\Parameter(in="body", name="body", description="提交的数据", required=true,
     *          @SWG\Schema(ref="#/definitions/settingAbout")
     *     ),
     *     @SWG\Response(response=200,description="success"),
     *     @SWG\Response(response=400,description="failed"),
     *     @SWG\Response(response=401,description="未登录")
     * )
     */
    public function about(Request $request)
    {
        $model = $this->model->findModel(config('website.setting.id'));

        $model->fill($request->only(['about_title', 'content']));
        $model->save();

        return $this->resourceInstance(Setting::class, $model)
            ->setStamp('about');
    }
}
