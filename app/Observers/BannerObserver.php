<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Observers;


use App\Models\Banner;
use Illuminate\Support\Facades\Auth;

/**
 * Class BannerObserver
 * @package App\Observers
 */
class BannerObserver
{
    /**
     * @param Banner $model
     * @return bool
     */
    public function created(Banner $model)
    {
        return true;
    }

    /**
     * @param Banner $model
     */
    public function saving(Banner $model)
    {
        //
    }

    /**
     * @param Banner $model
     */
    public function updated(Banner $model)
    {
        //
    }

    /**
     * @param Banner $model
     */
    public function deleted(Banner $model)
    {
        //
    }

    /**
     * @param Banner $model
     */
    public function restored(Banner $model)
    {
        //
    }
}
