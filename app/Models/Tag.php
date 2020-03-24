<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Models;

use App\Models\traits\PublishTrait;
use App\Models\traits\SoftDeleteTrait;

/**
 * Class Tag
 * @package App\Models
 *
 * @property integer $id
 * @property string $name
 * @property integer $status
 * @property integer $created_at
 * @property integer $deleted_at
 * @property integer $flag
 *
 * @property-read Item[] $items
 */
class Tag extends BaseModel
{
    use PublishTrait, SoftDeleteTrait;

    protected $fillable = [
        'name', 'status', 'flag'
    ];

    const UPDATED_AT = null;

    /**
     * @inheritdoc
     */
    public function getTable()
    {
        return 'tags';
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function items()
    {
        return $this->belongsToMany(Item::class, 'tagables');
    }
}
