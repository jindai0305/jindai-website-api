<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Observers;


use App\Models\Link;
use Illuminate\Support\Facades\Auth;

/**
 * Class LinkObserver
 * @package App\Observers
 */
class LinkObserver
{
    /**
     * @param Link $model
     * @return bool
     */
    public function created(Link $model)
    {
        return true;
    }

    /**
     * @param Link $model
     * @return bool
     */
    public function saving(Link $model)
    {
        //
    }

    /**
     * @param Link $model
     */
    public function updated(Link $model)
    {
        //
    }

    /**
     * @param Link $model
     */
    public function deleted(Link $model)
    {
        //
    }

    /**
     * @param Link $model
     */
    public function restored(Link $model)
    {
        //
    }
}
