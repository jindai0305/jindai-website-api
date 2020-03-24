<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Models;


use App\Models\traits\FlagTrait;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserRelation
 * @package App\Models
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $relation_id
 * @property string $type
 * @property integer $flag
 *
 * @property-read Item| $relationModel
 * @property-read User $user
 */
class UserRelation extends Model
{
    use FlagTrait;

    public $timestamps = false;

    const FLAG_APPROVE = 0x1; // 点赞
    const FLAG_COLLECT = 0x2; // 收藏

    const TYPE_ITEM = 'item';
    const TYPE_COMMENT = 'comment';

    protected $fillable = [
        'user_id', 'relation_id', 'type', 'flag'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function relationModel()
    {
        switch ($this->type) {
            case self::TYPE_COMMENT:
                return $this->belongsTo(Comment::class, 'relation_id', 'id');
                break;
            case self::TYPE_ITEM:
            default:
                return $this->belongsTo(Item::class, 'relation_id', 'id');
                break;
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * @param $flag
     * @param $column
     */
    public function toggleRelation($flag, $column)
    {
        if ($this->hasFlag($flag)) {
            $this->removeFlag($flag, true);
            $this->relationModel->increment($column, -1);
        } else {
            $this->addFlag($flag, true);
            $this->relationModel->increment($column, 1);
        }
    }

    /**
     * @return bool
     */
    public function hasCollect()
    {
        return $this->hasFlag(self::FLAG_COLLECT);
    }

    /**
     * @return bool
     */
    public function hasApprove()
    {
        return $this->hasFlag(self::FLAG_APPROVE);
    }
}
