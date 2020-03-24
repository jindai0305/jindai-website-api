<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Models\traits;

/**
 * Trait UsualTrait
 * @package App\Models\traits
 */
trait UsualTrait
{
    /**
     * 是否是新增
     * @return bool
     */
    public function isModelCreate()
    {
        return !$this->exists;
    }

    /**
     * @return string
     */
    public static function tableName()
    {
        return (new static())->getTable();
    }
}
