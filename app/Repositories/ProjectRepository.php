<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Repositories;


use App\Models\Project;
use Illuminate\Http\Request;

/**
 * Class ProjectRepository
 * @package App\Repositories
 */
class ProjectRepository extends BaseRepository
{
    public function __construct(Project $model)
    {
        $this->model = $model;
    }

    /**
     * @inheritdoc
     */
    public function rules($model)
    {
        return [
            'title' => 'required|max:25',
            'summary' => 'nullable|max:250',
            'website' => 'nullable|max:250',
            'github' => 'nullable|max:250',
            'type' => 'required|numeric',
        ];
    }

    /**
     * @inheritdoc
     */
    protected function buildQuery(Request $request)
    {
        $query = parent::buildQuery($request);

        if ($q = $request->query('q', false)) {
            $query->where('title', 'like', '%' . $q . '%');
        }
        return $query;
    }

    /**
     * @inheritdoc
     */
    protected function prepareReceptionStemQuery(Request $request)
    {
        $query = parent::prepareReceptionStemQuery($request);

        return $query->where('status', Project::STATUS_ONLINE);
    }
}
