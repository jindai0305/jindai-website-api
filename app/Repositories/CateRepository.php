<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Repositories;


use App\Models\Cate;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * Class CateRepository
 * @package App\Repositories
 */
class CateRepository extends BaseRepository
{
    public function __construct(Cate $model)
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
                'required', 'max:8',
                Rule::unique($model->getTable())->ignore($model),
            ]
        ];
    }

    /**
     * @inheritdoc
     */
    protected function buildQuery(Request $request)
    {
        $query = parent::buildQuery($request);

        if ($q = $request->query('q', false)) {
            $query->where('name', 'like', '%' . $q . '%');
        }

        return $query;
    }

    /**
     * @inheritdoc
     */
    protected function prepareReceptionStemQuery(Request $request)
    {
        $query = parent::prepareReceptionStemQuery($request);
        return $query->where('status', Cate::STATUS_ONLINE);
    }
}
