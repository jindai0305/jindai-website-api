<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Repositories;


use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * Class UserRepository
 * @package App\Repositories
 */
class UserRepository extends BaseRepository
{
    public function __construct(User $model)
    {
        $this->model = $model;
    }

    /**
     * @inheritdoc
     */
    public function rules($model)
    {
        return [
            'name' => [
                'required', 'max:255',
                Rule::unique($model->getTable())->ignore($model),
            ],
            'email' => [
                'required', 'max:255',
                Rule::unique($model->getTable())->ignore($model),
            ],
            'password' => 'nullable'
        ];
    }

    /**
     * @inheritdoc
     */
    protected function buildQuery(Request $request)
    {
        $query = parent::buildQuery($request);
        $query->with('userExpand');

        if ($q = $request->query('q', false)) {
            $query->where('name', 'like', '%' . $q . '%')
                ->where('nick_name', 'like', '%' . $q . '%');
        }
        return $query;
    }

    /**
     * @inheritdoc
     */
    protected function prepareReceptionStemQuery(Request $request)
    {
        return parent::prepareReceptionStemQuery($request);
    }

    /**
     * @inheritdoc
     */
    protected function requestExcept($model, Request $request)
    {
        /** @var User $model */
        if ($model->isModelCreate() || $request->user('api')->is_super) {
            return parent::requestExcept($model, $request);
        }

        if ($model->id == $request->user('api')->id) {
            return array_merge(parent::requestExcept($model, $request), [
                'name',
                'is_admin'
            ]);
        }

        return array_merge(parent::requestExcept($model, $request), [
            'name',
            'email'
        ]);
    }
}
