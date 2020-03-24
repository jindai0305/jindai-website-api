<?php
/**
 * This file is part of the Jindai.
 * @copyright Copyright (c) 2019 All Rights Reserved.
 * @author jindai <jindai0305@gmail.com>
 */

namespace App\Http\Controllers;

use App\Repositories\BaseRepository;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

/**
 * Class Controller
 * @package App\Http\Controllers
 *
 * @property-read \App\Models\User $user 当前登录用户信息
 * @property-read BaseRepository|\Illuminate\Database\Eloquent\Builder $model
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    protected $_user = null;
    protected $_model = null;

    public function __construct()
    {

    }

    /**
     * @return \App\Models\User|\Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function getUser()
    {
        if ($this->_user === null) {
            $this->_user = Auth::guard('api')->user();
        }
        return $this->_user;
    }

    /**
     * @return BaseRepository
     */
    public function getModel()
    {
        return $this->_model;
    }

    /**
     * @param $name
     * @return mixed
     * @throws \ErrorException
     */
    public function __get($name)
    {
        $getter = 'get' . $name;
        if (method_exists($this, $getter)) {
            return $this->$getter();
        }

        throw new \ErrorException('Undefined property: ' . PHP_EOL . __CLASS__ . '::$' . $name);
    }

    /**
     * @param $name
     * @param bool $checkVars
     * @return bool
     */
    public function hasProperty($name, $checkVars = true)
    {
        return $this->canGetProperty($name, $checkVars) || $this->canSetProperty($name, false);
    }

    /**
     * @param $name
     * @param bool $checkVars
     * @return bool
     */
    public function canGetProperty($name, $checkVars = true)
    {
        return method_exists($this, 'get' . $name) || $checkVars && property_exists($this, $name);
    }

    /**
     * @param $name
     * @param bool $checkVars
     * @return bool
     */
    public function canSetProperty($name, $checkVars = true)
    {
        return method_exists($this, 'set' . $name) || $checkVars && property_exists($this, $name);
    }

    /**
     * @param $name
     * @return bool
     */
    public function hasMethod($name)
    {
        return method_exists($this, $name);
    }
}
