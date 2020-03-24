<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Repositories;


use App\Models\Banner;
use Illuminate\Http\Request;

/**
 * Class BannerRepository
 * @package App\Repositories
 */
class BannerRepository extends BaseRepository
{
    public function __construct(Banner $model)
    {
        $this->model = $model;
    }

    /**
     * @inheritdoc
     */
    public function rules($model)
    {
        return [
            'image' => 'required',
            'title' => 'nullable|max:25',
            'summary' => 'nullable|max:250',
            'url' => 'nullable|max:500',
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

        return $query->where('status', Banner::STATUS_ONLINE);
    }
}
