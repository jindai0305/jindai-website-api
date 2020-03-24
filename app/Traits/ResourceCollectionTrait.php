<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Traits;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * Trait ResourceCollectionTrait
 * @package App\Traits
 *
 * @property-read \Illuminate\Support\Collection $collection
 */
trait ResourceCollectionTrait
{
    use ResourceTrait;

    protected function processCollection($request)
    {
        return $this->collection->map(function (JsonResource $resource) use ($request) {
            /** @var $resource ResourceTrait */
            return $resource->setStamp($this->stamp)->hide($this->withoutFields)->toArray($request);
        })->all();
    }

    public function toArray($request)
    {
        return $this->processCollection($request);
    }

    public function toDefault($request)
    {
    }
}
