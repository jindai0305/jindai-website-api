<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Repositories;


use App\Models\Comment;
use Illuminate\Http\Request;

/**
 * Class CommentRepository
 * @package App\Repositories
 */
class CommentRepository extends BaseRepository
{
    public function __construct(Comment $model)
    {
        $this->model = $model;
    }

    /**
     * @inheritdoc
     */
    public function rules($model)
    {
        return [
            'item_id' => 'required|exists:items,id',
            'content' => 'required',
            'reply_id' => 'nullable|exists:comments,id'
        ];
    }

    /**
     * @inheritdoc
     */
    protected function buildQuery(Request $request)
    {
        $query = parent::buildQuery($request);

        if ($item_id = $request->query('item_id', false)) {
            $query->where('item_id', $item_id);
        }
        return $query;
    }

    /**
     * @inheritdoc
     */
    protected function prepareReceptionStemQuery(Request $request)
    {
        $query = parent::prepareReceptionStemQuery($request);

        return $query->where('status', Comment::STATUS_ONLINE);
    }
}
