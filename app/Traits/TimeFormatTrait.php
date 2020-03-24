<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Traits;

/**
 * Trait TimeFormatTrait
 * @package App\Traits
 */
trait TimeFormatTrait
{
    public function freshTimestamp()
    {
        return time();
    }

    public function getCreatedAtAttribute($value)
    {
        return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $value)->diffForHumans();
    }

    public function getUpdatedAtAttribute($value)
    {
        if (is_null($value)) {
            return $value;
        }
        return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $value)->toDateTimeString();
    }
}
