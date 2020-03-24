<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Models;

use App\Models\traits\OperatorTrait;
use App\Models\traits\UsualTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Class BaseModel
 * @package App\Models
 *
 * @method boolean online
 * @method boolean offline
 * @method boolean softDeletes
 * @method \Illuminate\Database\Eloquent\Builder withTrashed
 * @mixin \Illuminate\Database\Eloquent\Builder
 * @mixin \App\Models\traits\FlagTrait
 */
class BaseModel extends Model
{
    use OperatorTrait, UsualTrait;

    public $timestamps = true;
    const CREATED_AT = 'created_at';
    const UPDATED_AT = 'updated_at';

    const STATUS_ONLINE = 1;
    const STATUS_OFFLINE = 0;

    public $casts = [
        'created_at' => 'timestamp',
        'updated_at' => 'timestamp',
        'deleted_at' => 'timestamp',
        'image' => 'array',
        'icon' => 'array'
    ];

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
     * @inheritdoc
     */
    public function getCasts()
    {
        return array_merge(parent::getCasts(), $this->appendCasts());
    }

    /**
     * 是否有自动补充事件
     *
     * @return bool
     */
    static protected function getObserver()
    {
        return false;
    }

    /**
     * @return array
     */
    protected function appendCasts(): array
    {
        return [];
    }
}
