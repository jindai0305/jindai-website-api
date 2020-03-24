<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Repositories;


use App\Models\Link;
use Illuminate\Http\Request;

/**
 * Class LinkRepository
 * @package App\Repositories
 */
class LinkRepository extends BaseRepository
{
    public function __construct(Link $model)
    {
        $this->model = $model;
    }

    /**
     * @inheritdoc
     */
    public function rules($model)
    {
        return [
            'name' => 'required|max:50',
            'website' => 'required|max:255',
            'summary' => 'required|nullable|max:255',
            'email' => 'nullable|max:255'
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

        return $query->where('status', Link::STATUS_ONLINE);
    }
}
