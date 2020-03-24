<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Models\traits;

/**
 * Trait OperatorTrait
 * @package App\Models\traits
 */
trait OperatorTrait
{
    public static function bootOperatorTrait()
    {
        if ($observer = static::getObserver()) {
            static::observe($observer);
        }
    }

    abstract static public function getObserver();
}
