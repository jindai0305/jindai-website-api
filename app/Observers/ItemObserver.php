<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Observers;

use App\Models\Item;

/**
 * Class ItemObserver
 * @package App\Observers
 */
class ItemObserver
{
    /**
     * @param Item $model
     * @return bool
     */
    public function created(Item $model)
    {
        return true;
    }

    /**
     * @param Item $model
     * @return bool
     */
    public function saving(Item $model)
    {
        if (!$model->keywords) {
            $model->keywords = array_column((array)$model->tags, 'name');
        }
        return true;
    }

    /**
     * @param Item $model
     */
    public function updated(Item $model)
    {
        //
    }

    /**
     * @param Item $model
     */
    public function deleted(Item $model)
    {
        //
    }

    /**
     * @param Item $model
     */
    public function restored(Item $model)
    {
        //
    }
}
