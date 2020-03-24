<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Models;

/**
 * Class LoginLog
 * @package App\Models
 *
 * @property int $id
 * @property int $user_id
 * @property string $action
 * @property string $content
 * @property string $score
 * @property string $time
 *
 * @property-read User $user
 */
class ScoreLog extends BaseModel
{
    public $timestamps = false;

    protected $fillable = [
        'user_id', 'action', 'content', 'score', 'time'
    ];

    /**
     * @inheritdoc
     */
    public function getTable()
    {
        return 'score_logs';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
