<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Repositories;


use App\Models\Tag;
use Illuminate\Http\Request;

/**
 * Class TagRepository
 * @package App\Repositories
 */
class TagRepository extends BaseRepository
{
    public function __construct(Tag $model)
    {
        $this->model = $model;
    }

    /**
     * @inheritdoc
     */
    public function rules($model)
    {
        return [
            'name' => 'required|unique:tags|max:8'
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

        return $query->where('status', Tag::STATUS_ONLINE);
    }
}
