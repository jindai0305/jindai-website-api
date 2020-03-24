<?php

namespace App\Jobs;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Http\Request;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Hash;

/**
 * Class RecordUserLogin
 * @package App\Jobs
 */
class RecordUserLogin implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $account;
    protected $password;
    protected $states;
    protected $ip;
    protected $agent;
    protected $time;

    /**
     * RecordUserLogin constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        $this->account = $request->get('account', false);
        $this->password = $request->get('password', false);
        $this->states = [];
        $this->ip = $request->ip();
        $this->agent = $request->userAgent();
        $this->time = time();
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        if (!$this->account || !$this->password) {
            return;
        }
        if (!$user = User::where('name', $this->account)->first()) {
            return;
        }
        if (!Hash::check($user->password, $this->password)) {
            return;
        }
        $user->loginLogs()->create([
            'states' => $this->states,
            'ip' => $this->ip,
            'agent' => $this->agent,
            'time' => $this->time
        ]);
    }
}
