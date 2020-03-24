<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Models;


use App\Models\traits\FlagTrait;
use App\Models\traits\PublishTrait;
use App\Models\traits\SoftDeleteTrait;
use App\Observers\ItemObserver;
use Illuminate\Support\Facades\Auth;

/**
 * Class Item
 * @package App\Models
 *
 * @property integer $id
 * @property string $title
 * @property integer $cate_id
 * @property string $summary
 * @property string $keywords
 * @property string $image
 * @property string $content
 * @property integer $view_nums
 * @property integer $approve_nums
 * @property integer $comment_nums
 * @property string $chosen
 * @property string $allow_comment
 * @property integer $copyright 版权 0默认 1转载
 * @property string $original_website 原链接网站
 * @property string $original_link 原链接
 * @property string $type
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $deleted_at
 * @property integer $flag
 *
 * @property Cate $cate
 * @property Tag[] $tags
 *
 * @method \Illuminate\Database\Eloquent\Builder popular()
 *
 * @property-read UserRelation[] $userRelations
 * @property-read UserRelation $userRelation
 */
class Item extends BaseModel
{
    use PublishTrait, SoftDeleteTrait;

    const COPYRIGHT_ORIGINAL = 0; // 原创
    const COPYRIGHT_REPRINT = 1; // 转载

    protected $fillable = [
        'title', 'cate_id', 'summary', 'keywords', 'image', 'content', 'chosen', 'type',
        'allow_comment', 'copyright', 'original_website', 'original_link', 'status', 'flag'
    ];

    /**
     * @inheritdoc
     */
    public function getTable()
    {
        return 'items';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function cate()
    {
        return $this->belongsTo(Cate::class, 'cate_id', 'id')
            ->select('id', 'name');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'tagables');
    }

    /**
     * @inheritdoc
     */
    static protected function getObserver()
    {
        return ItemObserver::class;
    }

    /**
     * @param $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopePopular($query)
    {
        /** @var \Illuminate\Database\Eloquent\Builder $query */
        return $query->where('view_nums', '>', 100);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userRelations()
    {
        return $this->hasMany(UserRelation::class, 'relation_id', 'id')
            ->where('type', '=', UserRelation::TYPE_ITEM);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function userRelation()
    {
        return $this->hasOne(UserRelation::class, 'relation_id', 'id')
            ->where('type', '=', UserRelation::TYPE_ITEM)
            ->where('user_id', '=', Auth::guard('api')->id());
    }

    /**
     * @return bool
     */
    public function isCollect()
    {
        return $this->userRelation && $this->userRelation->hasCollect();
    }

    /**
     * @return bool
     */
    public function isApprove()
    {
        return $this->userRelation && $this->userRelation->hasApprove();
    }

    /**
     * @inheritdoc
     */
    protected function appendCasts(): array
    {
        return [
            'keywords' => 'array'
        ];
    }
}
