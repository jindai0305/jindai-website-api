<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Http\Controllers\Api;

use App\Http\Resources\AttachmentsCollection;
use App\Models\Attachments;
use App\Models\User;
use App\Repositories\AttachmentsRepository;
use App\Repositories\UserRepository;
use App\Support\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

/**
 * Class DefaultController
 * @package App\Http\Controllers\Api
 *
 * @SWG\Tag(name="Others", description="其他")
 */
class DefaultController extends Controller
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
     * 测试时登录用户
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Database\Eloquent\Model
     *
     * @SWG\Get(path="/user/debug/{id}",
     *     tags={"Others"},
     *     description="测试时登录用户",
     *     produces={"application/json"},
     *     @SWG\Parameter(name="id",type="integer",in="path",description="资源id",required=true,default=1),
     *     @SWG\Response(response=200, description="success",
     *          @SWG\Schema(ref="#/definitions/userIndex")
     *     ),
     *     @SWG\Response(response=400,description="failed"),
     *     @SWG\Response(response=401, description="未登录")
     * )
     */
    public function debug(Request $request, $id)
    {
        if (!config('app.debug')) {
            abort(403, '非调试模式！');
        }
        /** @var User $user */
        $user = $this->model->findModel($id);

        $token = $user->createToken('Token Name')->accessToken;
        if ($request->has('redirect_uri')) {
            return redirect($request->query('redirect_uri'))
                ->cookie(Cookie::make(config('website.token.access.name'), $token, config('website.token.access.expired') * 24 * 60));
        }
        return $user;
    }

    /**
     * 退出登录
     *
     * @param Token $token
     * @param Request $request
     * @return string
     *
     * @SWG\Get(path="/user/logout",
     *     tags={"User"},
     *     description="退出登录",
     *     produces={"application/json"},
     *     security={{"api_key": {}}},
     *     @SWG\Response(response=200, description="success"),
     *     @SWG\Response(response=400,description="failed"),
     *     @SWG\Response(response=401, description="未登录")
     * )
     */
    public function loginOut(Token $token, Request $request)
    {
        if (Auth::guard('api')->check()) {
            Auth::guard('api')->user()->token()->delete();
        }
        $token->loginOut();
        if ($request->has('redirect_uri')) {
            return redirect($request->query('redirect_uri'));
        }

        return 'success';
    }

    /**
     * 上传文件
     *
     * @param Request $request
     * @return array
     *
     * @SWG\Post(path="/upload",
     *     tags={"Others"},
     *     summary="上传附件",
     *     description="通过 multipart/form-data 上传文件，返回文件名及网址",
     *     produces={"multipart/form-data"},
     *     security={{"api_key": {}}},
     *     @SWG\Parameter(in="formData", name="file", type="file", description="上传文件实例，multipart/form-data 表单数据", required=true),
     *     @SWG\Parameter(in="formData", name="type", type="string", enum={"avatar"}, description="制定上传类型，留空则代表默认路径，影响后台保存路径。", default="avatar"),
     *     @SWG\Parameter(in="formData", name="simditor", type="integer", enum={0, 1}, description="是否为 Simditor 兼容模式", default=0),
     *     @SWG\Response(response=200, description="success",
     *         @SWG\Schema(ref="#/definitions/userIndex")
     *     ),
     *     @SWG\Response(response=400, description="文件上传出错")
     * )
     */
    public function upload(Request $request)
    {
        $file = $request->file('file');
        if ($file->isValid()) {
            $diskType = $request->get('type');
            if (!in_array($diskType, ['banner', 'avatar', 'cover', 'item', 'project', 'link', 'other'])) {
                abort(422, 'not allow image upload type');
            }
            $fileName = $file->store($diskType, 'public');
            $path = 'storage/' . $fileName;
            $filePath = asset($path);

            $attachments = new Attachments();
            $attachments->name = $file->getClientOriginalName();
            $attachments->url = $filePath;
            $attachments->path = $path;
            $attachments->type = $diskType;
            $attachments->save();

            return response_send_data([
                'id' => $attachments->id,
                'name' => $attachments->name,
                'url' => $attachments->url,
                'type' => $attachments->type
            ]);
        } else {
            abort(422, 'file upload fail');
        }
    }
}
