<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Models\traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

/**
 * Trait FlagTrait
 * @package App\Models\traits
 */
trait FlagTrait
{
    /**
     * 判断属性上是否有某个旗标 (bit)
     * @param int|string $flag 旗标值或名称
     * @return bool
     */
    public function hasFlag($flag)
    {
        return $this->flag & $this->intFlagBit($flag) ? true : false;
    }

    /**
     * 判断属性上是否完全拥有某些旗标组合
     * @param int $flag 旗标组合值
     * @return bool
     */
    public function hasFullFlag($flag)
    {
        $flag = $this->intFlagBit($flag);
        return ($this->flag & $flag) === $flag ? true : false;
    }

    /**
     * 添加旗标
     * @param int|string $flag 旗标值或名称
     * @param bool $sync 是否同步写入数据库
     */
    public function addFlag($flag, $sync = false)
    {
        $flag = $this->intFlagBit($flag);
        $this->flag |= $flag;
        if ($sync === true && $this instanceof Model) {
            DB::table($this->getTable())
                ->where('id', $this->id)
                ->update(['flag' => DB::raw('flag | ' . $flag)]);
        }
    }

    /**
     * 移除旗标
     * @param int|string $flag 旗标值或名称
     * @param bool $sync 是否同步写入数据库
     */
    public function removeFlag($flag, $sync = false)
    {
        $flag = $this->intFlagBit($flag);
        $this->flag &= ~$flag;
        if ($sync === true && $this instanceof Model) {
            DB::table($this->getTable())
                ->where('id', $this->id)
                ->update(['flag' => DB::raw('flag & ~' . $flag)]);
        }
    }

    /**
     * 切换旗标
     * @param int|string $flag 旗标值或名称
     * @param bool $sync 是否同步写入数据库
     */
    public function toggleFlag($flag, $sync = false)
    {
        $flag = $this->intFlagBit($flag);
        $this->flag ^= $flag;
        if ($sync === true && $this instanceof Model) {
            DB::table($this->getTable())
                ->where('id', $this->id)
                ->update(['flag' => DB::raw('flag ^ ' . $flag)]);
        }
    }

    /**
     * @param int|string $flag 旗标值或名称
     * @return int
     */
    private function intFlagBit($flag)
    {
        if (is_int($flag)) {
            return $flag;
        }
        $key = 'self::FLAG_' . strtoupper($flag);
        return defined($key) ? constant($key) : 0;
    }
}
