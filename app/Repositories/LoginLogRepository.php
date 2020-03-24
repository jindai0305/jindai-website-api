<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Repositories;


use App\Models\LoginLog;
use Illuminate\Http\Request;

/**
 * Class LoginLogRepository
 * @package App\Repositories
 */
class LoginLogRepository extends BaseRepository
{
    public function __construct(LoginLog $model)
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
