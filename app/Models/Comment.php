<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Models;

use App\Models\traits\PublishTrait;
use App\Models\traits\SoftDeleteTrait;
use App\Observers\CommentObserver;

/**
 * Class Comment
 * @package App\Models
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $item_id
 * @property integer $reply_id
 * @property string $content
 * @property integer $favor
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $deleted_at
 * @property integer $flag
 *
 * @property-read User $user
 * @property-read Item $item
 */
class Comment extends BaseModel
{
    use PublishTrait, SoftDeleteTrait;

    protected $fillable = [
        'content', 'status', 'reply_id', 'user_id', 'item_id', 'flag'
    ];

    /**
     * @inheritdoc
     */
    public function getTable()
    {
        return 'comments';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function item()
    {
        return $this->belongsTo(Item::class, 'item_id', 'id');
    }

    /**
     * @inheritdoc
     */
    static protected function getObserver()
    {
        return CommentObserver::class;
    }
}
