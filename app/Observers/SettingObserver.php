<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Observers;


use App\Models\Setting;
use Illuminate\Support\Facades\Cache;

/**
 * Class SettingObserver
 * @package App\Observers
 */
class SettingObserver
{
    const EMPTY_STRING_COLUMNS = ['record', 'record_url', 'signature'];

    /**
     * @param Setting $model
     */
    public function saving(Setting $model)
    {
        foreach (self::EMPTY_STRING_COLUMNS as $column) {
            if (!$model->{$column}) {
                $model->{$column} = '';
            }
        }
    }

    /**
     * @param Setting $model
     */
    public function saved(Setting $model)
    {
        if ($model->isDirty(['about_title', 'content'])) {
            $key = route('about', [], false);
        } else {
            $key = route('setting', [], false);
        }
        Cache::forget(build_cache_key($key));
    }
}
