<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Repositories;


use App\Models\RequestRecordLog;
use Illuminate\Http\Request;

/**
 * Class RequestRecordLogRepository
 * @package App\Repositories
 */
class RequestRecordLogRepository extends BaseRepository
{
    public function __construct(RequestRecordLog $model)
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
        $query = parent::buildQuery($request);
        $query->with(['user.userExpand']);
        if (($userId = $request->query('user_id', false)) !== false) {
            $query->where('user_id', $userId);
        }
        if ($name = $request->query('name', false)) {
            $query->whereHas('user', function ($query) use ($name) {
                /** @var \Illuminate\Database\Eloquent\Builder $query */
                return $query->where('name', $name);
            });
        }
        if ($method = $request->query('method', false)) {
            $query->where('method', $method);
        }
        if ($path = $request->query('path', false)) {
            $query->where('router', $path);
        }
        if ($ip = $request->query('ip', false)) {
            $query->where('ip', $ip);
        }
        if ($startTime = $request->query('start_time', false)) {
            $query->where('time', '>=', strtotime($startTime));
        }
        if ($endTime = $request->query('end_time', false)) {
            $query->where('time', '<=', strtotime($endTime));
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
}
