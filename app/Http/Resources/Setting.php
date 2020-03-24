<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 Jindai.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Http\Resources;

use App\Traits\ResourceTrait;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Class Setting
 * @package App\Http\Resources
 *
 * @mixin \App\Models\Setting
 */
class Setting extends JsonResource
{
    use ResourceTrait;

    /**
     * @param $request
     * @return array
     *
     * @SWG\Definition(
     *     definition="settingDefault",
     *     type="object",
     *     allOf = {
     *          @SWG\Schema(ref="#/definitions/settingBasis"),
     *          @SWG\Schema(ref="#/definitions/settingModule"),
     *          @SWG\Schema(ref="#/definitions/settingPersonal")
     *     }
     * )
     */
    protected function toDefault($request)
    {
        return array_merge(
            $this->toBasis($request),
            $this->toModule($request),
            $this->toPersonal($request)
        );
    }

    /**
     * @param $request
     * @return array
     *
     * @SWG\Definition(
     *     definition="settingBasis",
     *     type="object",
     *     @SWG\Property(property="title", type="string", description="标题", example="计算机网络"),
     *     @SWG\Property(property="description", type="string", description="说明", example="这是一个说明"),
     *     @SWG\Property(property="keywords", type="array", description="关键词",
     *          @SWG\Items(type="string", example="PHP")
     *     ),
     *     @SWG\Property(property="logo", type="string", description="logo", example="/path/to/image"),
     *     @SWG\Property(property="repair", type="boolean", description="维修", example=false),
     *     @SWG\Property(property="record", type="string", description="备案号", example="浙ICP****"),
     *     @SWG\Property(property="record_url", type="string", description="备案跳转", example="***")
     * )
     */
    protected function toBasis($request)
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'keywords' => $this->keywords,
            'logo' => $this->logo ?: new \StdClass(),
            'repair' => $this->repair,
            'record' => $this->record,
            'record_url' => $this->record_url,
        ];
    }

    /**
     * @param $request
     * @return array
     *
     * @SWG\Definition(
     *     definition="settingModule",
     *     type="object",
     *     @SWG\Property(property="message", type="boolean", description="开启留言", example=false),
     *     @SWG\Property(property="comment", type="boolean", description="开启评论", example=false),
     *     @SWG\Property(property="chat", type="boolean", description="开启聊天", example=false),
     *     @SWG\Property(property="reward", type="boolean", description="开启打赏", example=false),
     *     @SWG\Property(property="alipay", type="string", description="二维码", example="/path/to/image"),
     *     @SWG\Property(property="wechat", type="string", description="二维码", example="/path/to/image"),
     * )
     */
    protected function toModule($request)
    {
        return [
            'message' => $this->message,
            'comment' => $this->comment,
            'chat' => $this->chat,
            'reward' => $this->reward,
            'alipay' => $this->alipay ?: new \StdClass(),
            'wechat' => $this->wechat ?: new \StdClass(),
        ];
    }

    /**
     * @param $request
     * @return array
     *
     * @SWG\Definition(
     *     definition="settingPersonal",
     *     type="object",
     *     @SWG\Property(property="nick_name", type="string", description="昵称", example="这是一个昵称"),
     *     @SWG\Property(property="signature", type="string", description="签名", example="这是一个签名"),
     *     @SWG\Property(property="avatar", type="string", description="logo", example="/path/to/image"),
     *     @SWG\Property(property="contact", type="boolean", description="联系我", example=false),
     *     @SWG\Property(property="visibility", type="boolean", description="整个板块", example=false),
     * )
     */
    protected function toPersonal($request)
    {
        return [
            'nick_name' => $this->nick_name,
            'signature' => $this->signature,
            'avatar' => $this->avatar ?: new \StdClass(),
            'contact' => $this->contact,
            'visibility' => $this->visibility,
        ];
    }


    /**
     * @param $request
     * @return array
     *
     * @SWG\Definition(
     *     definition="settingAbout",
     *     type="object",
     *     @SWG\Property(property="content", type="string", description="内容", example="计算机网络"),
     * )
     */
    protected function toAbout($request)
    {
        return [
            'about_title' => $this->about_title,
            'content' => $this->content
        ];
    }
}
