<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Repositories;

use App\Models\Attachments;
use Illuminate\Http\Request;

/**
 * Class AttachmentsRepository
 * @package App\Repositories
 */
class AttachmentsRepository extends BaseRepository
{
    public function __construct(Attachments $model)
    {
        $this->model = $model;
    }

    /**
     * @inheritdoc
     */
    public function rules($model)
    {
        return [
            'url' => 'required',
            'path' => 'required'
        ];
    }

    /**
     * @inheritdoc
     */
    protected function buildQuery(Request $request)
    {
        $query = parent::buildQuery($request);

        $type = $request->query('type', 'banner');
        $query->where('type', '=', $type);

        return $query;
    }
}
