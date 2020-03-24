<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Http\Middleware;

use App\Support\Response;
use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as HttpResponse;

/**
 * Class PrepareResponseSend
 * @package App\Http\Middleware
 *
 * @property-read Response $response
 */
class PrepareResponseSend
{
    private $response = null;

    /**
     * @param Request $request
     * @param Closure $next
     * @return JsonResponse|mixed
     * @throws \Illuminate\Contracts\Container\BindingResolutionException
     */
    public function handle($request, Closure $next)
    {
        $middleware = $request->route()->gatherMiddleware();
        // 使用了中间件admin 代表为后端接口 设置请求场景为admin
        if (in_array('admin', $middleware)) {
            $request->offsetSet('stem', 'admin');
        } else {
            $request->offsetSet('stem', 'reception');
        }
        $response = $next($request);

        // 非正常响应请求
        if ($response instanceof JsonResponse && !$response->isSuccessful()) {
            return $response;
        }

        if (!$request->expectsJson()) {
            return $response;
        }
        /** @var Response $response */
        $this->response = app()->make(Response::class);
        $this->response->setStatusCode($response->getStatusCode());
        $this->splitResponse($response);
        return $this->response->send();
    }

    private function splitResponse(HttpResponse $jsonResponse)
    {
        $data = $this->computeResponse($jsonResponse);
        $this->response->setContent($this->computeCode($data));
    }

    /**
     * @param $jsonResponse
     * @return array|string
     */
    private function computeResponse($jsonResponse)
    {
        if ($jsonResponse instanceof JsonResponse) {
            $content = $jsonResponse->getData();
            return is_object($content) ? (array)$content : $content;
        }
        /** @var HttpResponse $jsonResponse */
        return $jsonResponse->getContent();
    }

    /**
     * @param $data
     * @return mixed
     */
    private function computeCode($data)
    {
        if (isset($data['meta'])) {
            $this->response->setMeta($data['meta']);
            unset($data['meta']);
        }
        return isset($data) ? (isset($data['data']) ? $data['data'] : $data) : '';
    }

    /**
     * @param JsonResponse $response
     * @return JsonResponse
     */
    protected function prepareSend($response)
    {
        if (method_exists($response, 'getData')) {
            $response->setData($this->rebuildContent($response->getData()));
        }
        return $response;
    }

    /**
     * @param $content
     * @return array
     */
    protected function rebuildContent($content)
    {
        return array_merge([
            'error_code' => 200,
            'error_msg' => 'success'
        ], (array)$content);
    }
}
