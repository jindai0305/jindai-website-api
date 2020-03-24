<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Support;


use Elasticsearch\ClientBuilder;

/**
 * Class ElasticSearch
 * @package App\Support
 */
class ElasticSearch
{
    protected static $client;

    /**
     * 查找
     *
     * @param $params
     * @return array|callable
     */
    public function search($params)
    {
        try {
            return $this->getClient()->search($this->buildParams($params));
        } catch (\Exception $exception) {
            return [];
        }
    }

    /**
     * @return \Elasticsearch\Client
     */
    protected function getClient()
    {
        if (self::$client === null) {
            $clientBuilder = ClientBuilder::create();
            $clientBuilder->setHosts(config('elasticsearch.config.hosts'));
            self::$client = $clientBuilder->build();
        }

        return self::$client;
    }

    /**
     * 获取索引
     * @return \Illuminate\Config\Repository|mixed
     */
    protected function getIndex()
    {
        return config('elasticsearch.config.index');
    }

    /**
     * @param $params
     * @return array
     */
    protected function buildParams($params)
    {
        return array_merge([
            'index' => $this->getIndex()
        ], $params);
    }
}
