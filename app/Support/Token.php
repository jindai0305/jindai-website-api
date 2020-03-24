<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Support;

use App\Exceptions\LoginFailedException;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Support\Facades\Cookie;

/**
 * Class Token
 * @package App\Support
 */
class Token
{
    protected $_request;

    /**
     * Token constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->_request = $request;
    }

    /**
     * @param $name
     * @param $password
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function createToken($name, $password)
    {
        try {
            $response = $this->_request->guzzleHttpRequest('POST_JSON', config('app.url') . '/oauth/token', [
                'grant_type' => 'password',
                'client_id' => config('website.passport.client_id'),
                'client_secret' => config('website.passport.client_secret'),
                'username' => $name,
                'password' => $password,
                'scope' => '',
            ]);
            $token = json_decode((string)$response->getBody()->getContents(), true);
            return $this->recordCookies($token);
        } catch (\Exception $exception) {
            $this->handlerException($exception);
        }
    }

    /**
     * @param $token
     * @return mixed
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function refreshToken($token)
    {
        try {
            $response = $this->_request->guzzleHttpRequest('POST_JSON', config('app.url') . '/oauth/token', [
                'form_params' => [
                    'grant_type' => 'refresh_token',
                    'refresh_token' => $token,
                    'client_id' => config('website.passport.client_id'),
                    'client_secret' => config('website.passport.client_secret'),
                    'scope' => '*',
                ],
            ]);
            $token = json_decode((string)$response->getBody()->getContents(), true);
            return $this->recordCookies($token);
        } catch (\Exception $exception) {
            $this->handlerException($exception);
        }
    }

    /**
     * 退出登录
     */
    public function loginOut()
    {
        $this->invalidCookies();
    }

    /**
     * @param \Exception $exception
     */
    protected function handlerException(\Exception $exception)
    {
        $status_code = $exception->getCode() ?: 401;
        $response = [
            'error' => 'invalid_credentials',
            'error_description' => 'The user credentials were incorrect.',
            'message' => 'The user credentials were incorrect.'
        ];

        if ($exception instanceof ClientException) {
            if ($exception->hasResponse()) {
                $response = json_decode($exception->getResponse()->getBody()->getContents(), true);
            }
        }

        if (count($response) && $status_code === 403) {
            $message = current($response);
        } else {
            $message = end($response);
        }
        $this->invalidCookies();

        throw new LoginFailedException($response, $message, $status_code);
    }

    /**
     * 给请求附加cookie
     * @param array $token
     * @return array
     */
    protected function recordCookies(array $token)
    {
        Cookie::queue(Cookie::make(config('website.token.access.name'), $token['access_token'], config('website.token.access.expired') * 24 * 60));
        Cookie::queue(Cookie::make(config('website.token.refresh.name'), $token['refresh_token'], config('website.token.refresh.expired') * 24 * 60));

        return $token;
    }

    /**
     * 退出登录时清空cookie
     */
    protected function invalidCookies()
    {
        Cookie::queue(Cookie::make(config('website.token.access.name'), '', -1));
        Cookie::queue(Cookie::make(config('website.token.refresh.name'), '', -1));
    }
}
