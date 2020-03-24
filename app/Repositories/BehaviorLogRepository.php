<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Repositories;


use App\Models\BehaviorLog;
use Illuminate\Http\Request;

/**
 * Class BehaviorLogRepository
 * @package App\Repositories
 */
class BehaviorLogRepository extends BaseRepository
{
    public function __construct(BehaviorLog $model)
    {
        $this->model = $model;
    }

    /**
     * @inheritdoc
     */
    public function rules($model)
    {
        return [];
    }

    /**
     * @inheritdoc
     */
    protected function buildQuery(Request $request)
    {
        return parent::buildQuery($request);
    }

    /**
     * @inheritdoc
     */
    protected function prepareReceptionStemQuery(Request $request)
    {
        return parent::prepareReceptionStemQuery($request);
    }
}
