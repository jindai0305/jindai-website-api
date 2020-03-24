<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Models;

use App\Models\traits\PublishTrait;
use App\Models\traits\SoftDeleteTrait;
use App\Observers\BannerObserver;

/**
 * Class Banner
 * @package App\Models
 *
 * @property integer $id
 * @property string $title
 * @property string $summary
 * @property string $image
 * @property string $url
 * @property integer $status
 * @property integer $created_at
 * @property integer $deleted_at
 * @property integer $flag
 */
class Banner extends BaseModel
{
    use SoftDeleteTrait, PublishTrait;

    protected $fillable = [
        'title', 'summary', 'image', 'url', 'status', 'flag'
    ];


    const UPDATED_AT = null;

    /**
     * @inheritdoc
     */
    public function getTable()
    {
        return 'banners';
    }

    static protected function getObserver()
    {
        return BannerObserver::class;
    }
}
