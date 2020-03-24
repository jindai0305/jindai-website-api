<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Scopes;

use \Illuminate\Database\Eloquent\Builder;
use \Illuminate\Database\Eloquent\Model;

/**
 * Class SoftDeletingScope
 * @package App\Scopes
 */
class SoftDeletingScope extends \Illuminate\Database\Eloquent\SoftDeletingScope
{
    /**
     * @inheritdoc
     */
    public function apply(Builder $builder, Model $model)
    {
        $builder->where([$model->getQualifiedDeletedAtColumn() => 0]);
    }

    /**
     * @inheritdoc
     */
    protected function addRestore(Builder $builder)
    {
        $builder->macro('restore', function (Builder $builder) {
            $builder->withTrashed();

            return $builder->update([$builder->getModel()->getDeletedAtColumn() => 0]);
        });
    }
}
