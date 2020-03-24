<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Models;

use App\Models\traits\PublishTrait;
use App\Models\traits\SoftDeleteTrait;
use App\Observers\LinkObserver;

/**
 * Class Link
 * @package App\Models
 *
 * @property integer $id
 * @property string $name
 * @property string $icon
 * @property string $website
 * @property string $summary
 * @property string $email
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property integer $deleted_at
 * @property integer $flag
 */
class Link extends BaseModel
{
    use PublishTrait, SoftDeleteTrait;

    protected $fillable = [
        'name', 'icon', 'summary', 'website', 'email', 'status', 'flag'
    ];

    /**
     * @inheritdoc
     */
    public function getTable()
    {
        return 'links';
    }

    /**
     * @inheritdoc
     */
    static protected function getObserver()
    {
        return LinkObserver::class;
    }
}
