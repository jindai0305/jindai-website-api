<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Support;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Handler\CurlHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Middleware;
use GuzzleHttp\RequestOptions;

/**
 * Class Request
 * @package App\Support
 *
 * @property-read Client $client
 */
class Request
{
    const MAX_RETRIES = 3;

    protected $client;

    public function __construct()
    {
        $handleStack = HandlerStack::create(new CurlHandler());

        $handleStack->push(Middleware::retry($this->retryDecider(), $this->retryDelay()));

        $this->client = new Client(['handle' => $handleStack]);
    }

    /**
     * 使用 GuzzleHttp 进行 HTTP 请求
     *
     * @param string $method 请求方法 支持 POST GET XXX_JSON
     * @param string $url 目标网址
     * @param array $params 请求参数或内容体，其中 @ 开头的参数表示文件
     * @param array $config 额外的配置
     * @return mixed|\Psr\Http\Message\ResponseInterface|string
     * @throws \GuzzleHttp\Exception\GuzzleException
     * @return mixed|\Psr\Http\Message\ResponseInterface|string
     */
    public function guzzleHttpRequest($method, $url, $params = [], array $config = [])
    {
        $http = [
//            RequestOptions::TIMEOUT => 3
        ];
        $method = strtoupper($method);
        $headers = [];
        if (($pos = strpos($method, '_JSON')) !== false) {
            $headers['Content-Type'] = 'application/json';
            $http['method'] = substr($method, 0, $pos);
            $http[RequestOptions::BODY] = json_encode($params);
        } else {
            $http['method'] = $method;
            if (is_string($params)) {
                if ($method === 'POST' || $method === 'PUT' || $method === 'PATCH') {
                    $http[RequestOptions::BODY] = $params;
                } else {
                    $http[RequestOptions::QUERY] = $params;
                }
            } elseif ($method === 'POST' || $method === 'PUT' || $method === 'PATCH') {
                $boundary = false;
                foreach ($params as $key => $value) {
                    if (substr($key, 0, 1) === '@') {
                        $boundary = md5(microtime(true));
                        break;
                    }
                }
                if ($boundary === false) {
                    $headers['Content-Type'] = 'application/x-www-form-urlencoded';
                    $http[RequestOptions::FORM_PARAMS] = $params;
                } else {
                    $headers['Content-Type'] = 'multipart/form-data;';
                    $http[RequestOptions::MULTIPART] = [];
                    foreach ($params as $key => $value) {
                        if (substr($key, 0, 1) === '@') {
                            if (is_string($value)) {
                                $http[RequestOptions::MULTIPART][] = [
                                    'name' => basename($value),
                                    'contents' => fopen($value, 'r'),
                                ];
                            } elseif (isset($value['name'], $value['content'])) {
                                $http[RequestOptions::MULTIPART][] = [
                                    'name' => substr($key, 1),
                                    'contents' => $value['content'],
                                    'filename' => $value['name'],
                                ];
                            }
                        } else {
                            $http[RequestOptions::MULTIPART][] = [
                                'name' => $key,
                                'contents' => $value,
                            ];
                        }
                    }
                }
            } elseif (count($params) > 0) {
                $url = $url . (strpos($url, '?') === false ? '?' : '&') . http_build_query($params);
            }
        }

        if (isset($config[RequestOptions::HEADERS]) && is_array($config[RequestOptions::HEADERS])) {
            $config[RequestOptions::HEADERS] = array_merge($config[RequestOptions::HEADERS], $headers);
        } else {
            $config[RequestOptions::HEADERS] = $headers;
        }
        $basic = false;
        if (isset($config['basic']) && $config['basic'] === true) {
            $basic = true;
            unset($config['basic']);
        }
        $config = array_merge($http, $config);
        $response = $this->client->request($http['method'], $url, $config);
        if ($basic === true) {
            return $response->getBody()->getContents();
        } else {
            return $response;
        }
    }

    /**
     * retryDecider
     * 返回一个匿名函数, 匿名函数若返回false 表示不重试，反之则表示继续重试
     * @return \Closure
     */
    protected function retryDecider()
    {
        return function (
            $retries,
            Request $request,
            \GuzzleHttp\Psr7\Response $response = null,
            RequestException $exception = null
        ) {
            // 超过最大重试次数，不再重试
            if ($retries >= self::MAX_RETRIES) {
                return false;
            }

            // 请求失败，继续重试
            if ($exception instanceof ConnectException) {
                return true;
            }

            if ($response) {
//                 如果请求有响应，但是状态码大于等于500，继续重试(这里根据自己的业务而定)
                if ($response->getStatusCode() >= 500) {
                    return true;
                }
            }

            return false;
        };
    }

    /**
     * 返回一个匿名函数，该匿名函数返回下次重试的时间（毫秒）
     * @return \Closure
     */
    protected function retryDelay()
    {
        return function ($numberOfRetries) {
            return 1000 * $numberOfRetries;
        };
    }
}
