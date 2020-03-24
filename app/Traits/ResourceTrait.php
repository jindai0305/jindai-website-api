<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Traits;

/**
 * Trait ResourceTrait
 * @package App\Traits
 */
trait ResourceTrait
{
    // 获取附加信息
    public $meta = [];

    // 调用的类型
    protected $stamp = 'default';

    // 需要忽略的字段
    protected $withoutFields = [];

    /**
     * @param $request
     * @return mixed
     */
    public function toArray($request)
    {
        return $this->{'to' . ucfirst($this->stamp)}($request);
    }

    /**
     * @param array $fields
     * @return $this
     */
    public function hide(array $fields)
    {
        $this->withoutFields = $fields;
        return $this;
    }

    /**
     * @param string $stamp
     * @return $this
     */
    public function setStamp(string $stamp)
    {
        $this->stamp = $stamp;
        return $this;
    }

    /**
     * @param array $meta
     * @return $this
     */
    public function addMeta(array $meta)
    {
        $this->meta = $meta;
        return $this;
    }

    /**
     * @param $request
     * @return array
     */
    public function with($request)
    {
        if (count($this->meta)) {
            return ['meta' => $this->meta];
        }
        return [];
    }

    protected function filterFields($array)
    {
        return collect($array)->forget($this->withoutFields)->toArray();
    }

    /**
     * @param $class
     * @param $model
     * @return static
     */
    protected function resourceInstance($class, $model)
    {
        return new $class($model);
    }

    abstract protected function toDefault($request);
}
