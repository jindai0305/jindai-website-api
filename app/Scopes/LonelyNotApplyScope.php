<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Scopes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

/**
 *
 * Class LonelyApplyScope
 * @package App\Scopes
 *
 * @property string $_column 字段
 * @property integer $_value 值
 */
class LonelyNotApplyScope implements Scope
{
    private $_column;
    private $_value;

    public function __construct(string $column = 'status', $value = 1)
    {
        $this->_column = $column;
        $this->_value = $value;
    }

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param  \Illuminate\Database\Eloquent\Builder $builder
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        $builder->where($model->getTable() . '.' . $this->_column, $this->_value);
    }
}
