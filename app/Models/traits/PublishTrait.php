<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Models\traits;

/**
 * Trait PublishTrait
 * @package App\Models\traits
 */
trait PublishTrait
{
    /**
     * 上架
     *
     * @return mixed
     */
    public function online()
    {
        if ($this->fireModelEvent('beforeOnline') === false) {
            return false;
        }
        $this->{$this->getPublishColumn()} = $this->getPublishValue();
        if (false === $this->save()) {
            return false;
        }
        if ($this->fireModelEvent('afterOnline') === false) {
            return false;
        }
        return true;
    }

    /**
     * 下架
     *
     * @return mixed
     */
    public function offline()
    {
        if ($this->fireModelEvent('beforeOffline') === false) {
            return false;
        }
        $this->{$this->getPublishColumn()} = $this->getUnPublishValue();
        if (false === $this->save()) {
            return false;
        }
        if ($this->fireModelEvent('afterOffline') === false) {
            return false;
        }
        return true;
    }

    /**
     * 是否上架
     *
     * @return bool
     */
    public function isOnline()
    {
        return $this->{$this->getPublishColumn()} == $this->getPublishValue();
    }

    protected function getPublishColumn()
    {
        return defined('static::STATUS_COLUMN') ? static::STATUS_COLUMN : 'status';
    }

    protected function getPublishValue()
    {
        return defined('static::STATUS_ONLINE') ? static::STATUS_ONLINE : 1;
    }

    protected function getUnPublishValue()
    {
        return defined('static::STATUS_OFFLINE') ? static::STATUS_OFFLINE : 0;
    }
}
