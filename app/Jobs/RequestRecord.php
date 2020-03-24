<?php

namespace App\Jobs;

use App\Models\RequestRecordLog;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use \Illuminate\Http\Request;

class RequestRecord implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $time;
    protected $ip;
    protected $userId = 0;
    protected $module;
    protected $method;
    protected $router;
    protected $execTime;
    protected $status = 0;
    protected $response;
    protected $userAgent;
    protected $header;
    protected $bodyParams;

    /**
     * RequestRecord constructor.
     * @param Request $request
     * @param $start_time
     * @param $response
     */
    public function __construct(Request $request, $start_time, $response)
    {
        $this->execTime = microtime(true) - $start_time;
        $this->time = time();
        $this->ip = $request->ip();
        $this->userId = \Auth::guard('api')->id() ?: 0;
        $route = $request->route();
        $this->module = $route->getActionName();
        $this->method = $request->method();
        $this->router = $request->path();
        /** @var \Illuminate\Http\Response $response */
        try {
            $this->status = $response->getStatusCode();
            $this->response = $response->getContent();
        } catch (\Exception $e) {
            $this->status = 0;
            $this->response = [];
        }
        $this->userAgent = $request->header('User-Agent');
        $this->header = $request->headers->all();
        $this->bodyParams = $request->except(['password', 'stem']);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (!$this->filterInvalidRecord()) {
            return;
        }

        RequestRecordLog::query()->create([
            'time' => $this->time,
            'ip' => $this->ip,
            'user_id' => $this->userId,
            'module' => $this->module,
            'method' => $this->method,
            'router' => $this->router,
            'exec_time' => $this->execTime * 1000,
            'status' => $this->status,
            'response' => $this->response,
            'user_agent' => $this->userAgent,
            'header' => $this->header,
            'body_params' => json_encode($this->bodyParams)
        ]);
    }

    /**
     * 过滤无效的请求
     * @return boolean
     */
    protected function filterInvalidRecord()
    {
        if (!is_string($this->module)) {
            return false;
        }
        if (in_array($this->method, config('except.method'))) {
            return false;
        }
        if (in_array($this->router, config('except.router'))) {
            return false;
        }
        if (!strpos($this->module, '@')) {
            return false;
        }
        $routeArr = explode('\\', explode('@', $this->module)[0]);
        $controller = end($routeArr);
        if (in_array($controller, config('except.controller'))) {
            return false;
        }
        return true;
    }
}
