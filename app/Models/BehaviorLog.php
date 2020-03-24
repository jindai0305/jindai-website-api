<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Models;

/**
 * Class BehaviorLog
 * @package App\Models
 *
 * @property int $id
 * @property int $user_id
 * @property string $url
 * @property string $method
 * @property int $status
 * @property string $states
 * @property string $ip
 * @property string $agent
 * @property string $time
 *
 * @property-read User $user
 */
class BehaviorLog extends BaseModel
{
    public $timestamps = false;

    protected $fillable = [
        'user_id', 'method', 'states', 'ip', 'agent', 'time'
    ];

    /**
     * @inheritdoc
     */
    public function getTable()
    {
        return 'behavior_logs';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    /**
     * @inheritdoc
     */
    protected function appendCasts(): array
    {
        return [
            'states' => 'string',
            'agent' => 'string',
        ];
    }
}
