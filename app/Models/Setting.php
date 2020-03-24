<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Models;

use App\Observers\SettingObserver;

/**
 * Class Project
 * @package App\Models
 *
 * @property integer $id
 * @property string $title
 * @property string $description
 * @property string $keywords
 * @property string $logo
 * @property integer $repair 维修
 * @property string $record 备案号
 * @property string $record_url 备案跳转链接
 * @property integer $message 留言
 * @property integer $comment 评论
 * @property integer $chat 聊天
 * @property integer $reward
 * @property string $alipay 支付宝二维码
 * @property string $wechat 微信二维码
 * @property string $nick_name  昵称
 * @property string $signature 签名
 * @property string $avatar 头像
 * @property integer $contact 是否显示联系我按钮
 * @property integer $visibility 是否显示我的信息
 * @property string $about_title 关于我标题
 * @property string $content 关于我
 */
class Setting extends BaseModel
{
    public $timestamps = false;

    protected $fillable = [
        'title', 'description', 'keywords', 'logo', 'repair', 'record', 'record_url', 'message', 'comment', 'chat', 'reward',
        'alipay', 'wechat', 'nick_name', 'signature', 'avatar', 'contact', 'visibility', 'about_title', 'content'
    ];

    /**
     * @inheritdoc
     */
    public function getTable()
    {
        return 'settings';
    }

    /**
     * @inheritdoc
     */
    protected function appendCasts(): array
    {
        return [
            'logo' => 'array',
            'alipay' => 'array',
            'wechat' => 'array',
            'avatar' => 'array',
            'keywords' => 'array',
            'repair' => 'boolean',
            'message' => 'boolean',
            'comment' => 'boolean',
            'chat' => 'boolean',
            'reward' => 'boolean',
            'contact' => 'boolean',
            'visibility' => 'boolean',
        ];
    }

    /**
     * @inheritdoc
     */
    static protected function getObserver()
    {
        return SettingObserver::class;
    }
}
