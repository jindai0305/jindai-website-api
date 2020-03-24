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
 * Class Project
 * @package App\Models
 *
 * @property integer $id
 * @property string $title
 * @property string $summary
 * @property string $image
 * @property string $content
 * @property string $github
 * @property integer $website
 * @property integer $code
 * @property integer $keywords
 * @property integer $start_time
 * @property integer $end_time
 * @property integer $type
 * @property integer $status
 * @property integer $created_at
 * @property integer $deleted_at
 * @property integer $flag
 */
class Project extends BaseModel
{
    use PublishTrait, SoftDeleteTrait;

    const UPDATED_AT = null;

    protected $fillable = [
        'title', 'summary', 'image', 'content', 'github', 'website', 'code', 'keywords',
        'start_time', 'end_time', 'type', 'status', 'created_at', 'flag'
    ];

    /**
     * @inheritdoc
     */
    public function getTable()
    {
        return 'projects';
    }

    protected function appendCasts(): array
    {
        return [
            'image' => 'array',
            'code' => 'array',
            'keywords' => 'array',
            'start_time' => 'timestamp',
            'end_time' => 'timestamp'
        ];
    }
}
