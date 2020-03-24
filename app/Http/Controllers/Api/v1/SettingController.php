<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Http\Controllers\Api\v1;

use App\Http\Resources\Setting;
use App\Repositories\ItemRepository;
use App\Repositories\SettingRepository;
use Illuminate\Http\Request;

/**
 * Class SettingController
 * @package App\Http\Controllers\Api\v1
 *
 * @SWG\Tag(name="Setting", description="设置")
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
     * 获取网站设置
     *
     * @return array
     *
     * @SWG\Get(path="/setting",
     *     tags={"Setting"},
     *     description="获取网站设置",
     *     produces={"application/json"},
     *     @SWG\Response(response=200, description="success",
     *          @SWG\Schema(ref="#/definitions/settingDefault")
     *     ),
     *     @SWG\Response(response=400,description="failed"),
     *     @SWG\Response(response=401, description="未登录")
     * )
     */
    public function index()
    {
        return $this->resourceInstance(Setting::class, $this->model->findModel(config('website.setting.id')));
    }

    /**
     * 关于我
     *
     * @return array
     *
     * @SWG\Get(path="/about",
     *     tags={"Setting"},
     *     description="关于我",
     *     produces={"application/json"},
     *     @SWG\Response(response=200, description="success",
     *          @SWG\Schema(ref="#/definitions/settingAbout")
     *     ),
     *     @SWG\Response(response=400,description="failed"),
     *     @SWG\Response(response=401, description="未登录")
     * )
     */
    public function aboutMe()
    {
        return $this->resourceInstance(Setting::class, $this->model->findModel(config('website.setting.id')))
            ->setStamp('about');
    }
}
