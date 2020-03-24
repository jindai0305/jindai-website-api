<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Models;

/**
 * Class Tag
 * @package App\Models
 *
 * @property integer $id
 * @property integer $time
 * @property string $ip
 * @property integer $user_id
 * @property string $module
 * @property string $method
 * @property string $router
 * @property integer $exec_time
 * @property integer $status
 * @property string $response
 * @property string $user_agent
 * @property array $header
 * @property string $body_params
 *
 * @property-read User $user
 */
class RequestRecordLog extends BaseModel
{
    public $timestamps = false;

    protected $fillable = [
        'time', 'ip', 'user_id', 'module', 'method', 'router', 'exec_time', 'status', 'response', 'user_agent', 'header', 'body_params'
    ];

    /**
     * @inheritdoc
     */
    public function getTable()
    {
        return 'request_record_logs';
    }

    /**
     * @inheritdoc
     */
    protected function appendCasts(): array
    {
        return [
            'header' => 'array',
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
