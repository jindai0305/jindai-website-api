<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Models;

use App\Jobs\MoveUserBlack;
use App\Models\traits\FlagTrait;
use App\Models\traits\OperatorTrait;
use App\Models\traits\UsualTrait;
use App\Observers\UserObserver;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Laravel\Passport\HasApiTokens;
use League\OAuth2\Server\Exception\OAuthServerException;
use Symfony\Component\HttpFoundation\Response;

/**
 * Class User
 * @package App\Models
 *
 * @property integer $id
 * @property string $name
 * @property string $email
 * @property string $password
 * @property string $confirm_code
 * @property boolean $is_super
 * @property int $score
 * @property int $created_at
 * @property int $updated_at
 * @property int $flag
 *
 * @property-read UserExpand $userExpand
 *
 * @mixin \Illuminate\Database\Eloquent\Builder
 */
class User extends Authenticatable
{
    use HasApiTokens, Notifiable, FlagTrait, OperatorTrait, UsualTrait;

    const FLAG_DISABLE = 0x100; // 禁用
    const FLAG_MUTED = 0x20; // 禁言
    const FLAG_ADMIN = 0x10; // 管理员

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'confirm_code', 'is_super'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
        'deleted_at' => 'timestamp',
    ];

    /**
     * @inheritdoc
     */
    public function getTable()
    {
        return 'users';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function userExpand()
    {
        return $this->hasOne(UserExpand::class, 'id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function loginLogs()
    {
        return $this->hasMany(LoginLog::class, 'id', 'user_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function requestLogs()
    {
        return $this->hasMany(RequestRecordLog::class, 'id', 'user_id');
    }

    /**
     * @param $username
     * @return User|\Illuminate\Database\Eloquent\Model|object|null
     * @throws OAuthServerException
     */
    public function findForPassport($username)
    {
        if (filter_var($username, FILTER_VALIDATE_EMAIL)) {
            $model = $this->where('email', $username)->first();
        } else {
            $model = $this->where('name', $username)->first();
        }
        if ($model && !$model->can('login', $model)) {
            throw new OAuthServerException('Account `' . $username . '`` Is Disabled', Response::HTTP_FORBIDDEN, 'user in blacklist', Response::HTTP_FORBIDDEN);
        }
        return $model;
    }

    public function setPasswordAttribute($value)
    {
        $this->attributes['password'] = bcrypt($value);
        $this->attributes['confirm_code'] = md5($this->attributes['password']);
    }

    /**
     * @inheritdoc
     */
    static public function getObserver()
    {
        return UserObserver::class;
    }

    /**
     * @inheritdoc
     */
    public function freshTimestamp()
    {
        return time();
    }

    /**
     * @inheritdoc
     */
    public function fromDateTime($value)
    {
        return $value;
    }

    /**
     * 账户是否禁用
     *
     * @return bool
     */
    public function isDisabled()
    {
        if ($this->is_super) {
            return false;
        }
        return $this->hasFlag(self::FLAG_DISABLE);
    }

    /**
     * 是否禁言
     *
     * @return bool
     */
    public function isMuted()
    {
        if ($this->is_super) {
            return false;
        }
        return $this->hasFlag(self::FLAG_MUTED);
    }

    /**
     * 账号是否异常
     */
    public function isUnusual()
    {
        return $this->isDisabled() || $this->isMuted();
    }

    /**
     * 获取角色类型
     */
    public function getAccountRoles()
    {
        $roles = [];
        if ($this->is_super) {
            $roles[] = '超级管理员';
        }
        if ($this->isAdmin()) {
            $roles[] = '管理员';
        }
        return $roles;
    }

    /**
     * @return bool
     */
    public function isAdmin()
    {
        return $this->is_super || $this->hasFlag(self::FLAG_ADMIN);
    }

    /**
     * 填充用户其他信息
     * @param Request $request
     * @return bool|\Illuminate\Database\Eloquent\Model
     */
    public function fullUserExpand(Request $request)
    {
        if ($this->userExpand) {
            return $this->userExpand->update(array_merge([
                'active_at' => time(),
            ], $request->only(['nick_name', 'avatar', 'website', 'signature'])));
        }
        return $this->userExpand()->create(array_merge([
            'active_at' => time(),
            'avatar' => [
                'id' => 0,
                'url' => config('website.default.avatar')
            ]
        ], $request->only(['nick_name', 'avatar', 'website', 'signature'])));
    }

    /**
     * 移入黑名单
     */
    public function moveBlack()
    {
        $this->addFlag(self::FLAG_DISABLE, true);
        dispatch(new MoveUserBlack($this));
    }

    /**
     * 移出黑名单
     */
    public function removeBlack()
    {
        $this->removeFlag(self::FLAG_DISABLE, true);
    }

    /**
     * 禁言
     */
    public function muted()
    {
        $this->addFlag(self::FLAG_MUTED, true);
    }

    /**
     * 解除禁言
     */
    public function removeMuted()
    {
        $this->removeFlag(self::FLAG_MUTED, true);
    }

    /**
     * 权限
     * @return array
     */
    public static function permissionAction()
    {
        return [
            'moveBlack' => 'black',
            'removeBlack' => 'black'
        ];
    }

    /**
     * 失效token
     */
    public function invalidToken()
    {

    }
}
