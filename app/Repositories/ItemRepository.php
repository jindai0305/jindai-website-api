<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Repositories;


use App\Models\Cate;
use App\Models\Item;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class ItemRepository
 * @package App\Repositories
 */
class ItemRepository extends BaseRepository
{
    public function __construct(Item $model)
    {
        $this->model = $model;
    }

    /**
     * @inheritdoc
     */
    public function rules($model)
    {
        return [
            'title' => 'required|max:120',
            'cate_id' => 'required|exists:cates,id',
            'summary' => 'required|max:400',
            'image' => 'nullable|max:255',
            'content' => 'required',
            'allow_comment' => 'required|in:0,1',
            'copyright' => 'required|in:0,1',
            'original_website' => 'required_if:copyright,1|max:55',
            'original_link' => 'required_if:copyright,1|max:1000',
            'type' => 'required|numeric',
        ];
    }

    /**
     * @inheritdoc
     */
    public function findModel(int $id, Request $request = null)
    {
        $model = parent::findModel($id, $request);
        if ($this->getRequest($request)->routeIs('item-detail')) {
            $model->increment('view_nums', 1);
        }
        return $model;
    }

    /**
     * @inheritdoc
     */
    protected function buildQuery(Request $request)
    {
        $query = parent::buildQuery($request);
        // 关键词
        if ($q = $request->query('q', false)) {
            $query->where('title', 'like', '%' . $q . '%');
        }
        // 是否原创
        if (($copyright = $request->query('copyright', false)) !== false) {
            $query->where('copyright', (int)$copyright);
        }
        // 分类
        if ($cate = $request->query('cate', false)) {
            $query->where('cate_id', $cate);
        }
        // 标签
        if ($tag = $request->query('tag', false)) {
            $query->whereHas('tags', function ($query) use ($tag) {
                /** @var \Illuminate\Database\Eloquent\Builder $query */
                return $query->where('tags.id', $tag);
            });;
        }

        return $query;
    }

    /**
     * @inheritdoc
     */
    protected function prepareReceptionStemQuery(Request $request)
    {
        $query = parent::prepareReceptionStemQuery($request);

        $user = Auth::guard('api')->user();

        if ($user && $user->isAdmin() && !$request->routeIs('item-list')) {
            return $query;
        }

        return $query->where('status', Item::STATUS_ONLINE)
            ->whereHas('cate', function ($query) {
                /** @var Builder $query */
                $query->where('status', Cate::STATUS_ONLINE);
            });
    }
}
