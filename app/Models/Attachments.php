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
 * Class Attachments
 * @package App\Models
 *
 * @property integer $id
 * @property string $name
 * @property string $type
 * @property string $path
 * @property string $url
 * @property string $status
 * @property string $created_at
 * @property integer $deleted_at
 * @property integer $flag
 */
class Attachments extends BaseModel
{
    use SoftDeleteTrait, PublishTrait;

    protected $fillable = [
        'name', 'type', 'path', 'url', 'status', 'flag'
    ];

    const UPDATED_AT = null;

    /**
     * @inheritdoc
     */
    public function getTable()
    {
        return 'attachments';
    }
}
