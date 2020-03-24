<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Models;


use Illuminate\Database\Eloquent\Model;

/**
 * 用户信息拓展表
 *
 * Class UserExpand
 * @package App\Models
 *
 * @property integer $id users.id
 * @property string $avatar
 * @property string $nick_name
 * @property string $website
 * @property string $signature
 * @property integer $active_at
 *
 * @property-read User $user
 */
class UserExpand extends Model
{

    public $timestamps = false;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'nick_name', 'avatar', 'website', 'signature', 'active_at'
    ];

    public $casts = [
        'avatar' => 'array',
    ];

    /**
     * @inheritdoc
     */
    public function getTable()
    {
        return 'user_expand';
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'id', 'id');
    }
}
