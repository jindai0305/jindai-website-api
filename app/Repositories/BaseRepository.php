<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Repositories;

use App\Models\BaseModel;
use Illuminate\Http\Request;

/**
 * Class BaseRepository
 * @package App\Repositories
 *
 * @property \App\Models\BaseModel|\Illuminate\Database\Eloquent\Builder $model
 * @property \Illuminate\Database\Eloquent\Builder $query
 */
abstract class BaseRepository
{
    protected $model;

    protected $query;

    const STEM_RECEPTION = 'reception';

    const DEFAULT_LIMIT = 20;

    /**
     * @param int $id
     * @param Request|null $request
     * @return \App\Models\BaseModel
     */
    public function findModel(int $id, Request $request = null)
    {
        return $this->prepareModelQuery($this->getRequest($request))->findOrFail($id);
    }

    /**
     * @param Request $request
     * @param bool $runValidation
     * @return mixed
     */
    public function store(Request $request, $runValidation = true)
    {
        return $this->save($this->model, $request, $runValidation);
    }

    /**
     * @param $id
     * @param Request $request
     * @param bool $runValidation
     * @return mixed
     */
    public function update($id, Request $request, $runValidation = true)
    {
        return $this->save($this->findModel($id), $request, $runValidation);
    }

    /**
     * @param $id
     * @return bool|mixed|null
     * @throws \Exception
     */
    public function destroy($id)
    {
        if (is_array($id)) {
            $query = $this->model->whereIn('id', $id);
        } else {
            $query = $this->findModel($id);
        }
        return $query->delete();
    }

    /**
     * @param Request $request
     * @param int $limit
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function paginate(Request $request, $limit = self::DEFAULT_LIMIT)
    {
        list($page, $limit) = $this->getPageParams($request, $limit);

        $query = clone $this->getQuery($request);
        if (empty($query->getQuery()->orders)) {
            $query->orderBy('id', 'desc');
        }

        // 上一次请求的最大id
        if ($request->has('point')) {
            $query->where('id', '>', (int)$request->query('point'));
        } else {
            $query->offset($limit * max(0, $page - 1));
        }

        return $query->limit($limit)->get();
    }

    /**
     * @param Request $request
     * @param int $limit
     * @return array
     */
    public function getMeta(Request $request, $limit = self::DEFAULT_LIMIT)
    {
        list($page, $limit) = $this->getPageParams($request, $limit);

        return [
            'total' => $this->getQuery($request)->count(),
            'page' => $page,
            'limit' => $limit,
            'point' => $request->query('point', 0)
        ];
    }

    /**
     * @param Request $request
     * @param $limit
     * @return array
     */
    protected function getPageParams(Request $request, $limit)
    {
        $page = max(1, $request->get('page', 1));
        $limit = min(50, $request->get('limit', $limit));

        return [$page, $limit];
    }

    /**
     * @param \App\Models\BaseModel $model
     * @param Request $request
     * @param boolean $runValidation
     * @return mixed
     */
    protected function save($model, Request $request, $runValidation)
    {
        $model->fill($request->except($this->requestExcept($model, $request)));
        $runValidation && $this->validate($request, $model);
        $model->save();
        return $model;
    }

    /**
     * 验证
     * @param Request $request
     * @param $model
     */
    protected function validate(Request $request, $model)
    {
        $request->validate($this->rules($model));
    }

    /**
     * @param \App\Models\BaseModel $model
     * @return array
     */
    abstract public function rules($model);

    /**
     * @param Request $request
     * @return \Illuminate\Database\Eloquent\Builder|\App\Models\BaseModel
     */
    protected function getQuery(Request $request)
    {
        if ($this->query === null) {
            $this->query = $this->buildQuery($request);
        }
        return $this->query;
    }

    /**
     * 是否使用了软删除
     *
     * @return bool
     */
    protected function useSoftDelete()
    {
        if (method_exists($this->model, 'runSoftDelete')) {
            return true;
        }
        return false;
    }

    /**
     * 获取场景
     *
     * @param Request $request
     * @return string
     */
    protected function getStem(Request $request)
    {
        return $request->get('stem', self::STEM_RECEPTION);
    }

    /**
     * @param Request $request
     * @return \App\Models\BaseModel|\Illuminate\Database\Eloquent\Builder
     */
    protected function buildQuery(Request $request)
    {
        return $this->prepareModelQuery($request);
    }

    /**
     * @param Request $request
     * @return \App\Models\BaseModel|\Illuminate\Database\Eloquent\Builder
     */
    protected function prepareModelQuery(Request $request)
    {
        $stem = $this->getStem($request);
        return $this->{'prepare' . ucfirst($stem) . 'StemQuery'}($request);
    }

    /**
     * @param Request $request
     * @return \App\Models\BaseModel|\Illuminate\Database\Eloquent\Builder
     */
    protected function prepareAdminStemQuery(Request $request)
    {
        /** @var \Illuminate\Database\Eloquent\Builder $query */
        $query = $this->model->newQuery();
        // 传参查看已删除
        if ($request->query('withTrashed', false) && $this->useSoftDelete()) {
            $query->withTrashed();
        }
        if (($status = $request->query('status', 'all')) != 'all') {
            $query->where('status', '=', $status == 'up' ? BaseModel::STATUS_ONLINE : BaseModel::STATUS_OFFLINE);
        }

        return $query;
    }

    /**
     * @param Request $request
     * @return \App\Models\BaseModel|\Illuminate\Database\Eloquent\Builder
     */
    protected function prepareReceptionStemQuery(Request $request)
    {
        return $this->model->newQuery();
    }

    /**
     * @param Request|null $request
     * @return Request
     */
    protected function getRequest(Request $request = null)
    {
        return $request === null ? request() : $request;
    }

    /**
     * @param \App\Models\BaseModel $model
     * @param Request $request
     * @return array
     */
    protected function requestExcept($model, Request $request)
    {
        return ['stem'];
    }
}
