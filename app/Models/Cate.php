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
 * Class Cate
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
class Cate extends BaseModel
{
    use PublishTrait, SoftDeleteTrait;

    const UPDATED_AT = null;

    protected $fillable = [
        'name', 'status', 'flag'
    ];

    /**
     * @inheritdoc
     */
    public function getTable()
    {
        return 'cates';
    }

    public function items()
    {
        return $this->hasMany(Item::class, 'cate_id', 'id');
    }
}
