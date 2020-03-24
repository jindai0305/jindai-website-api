<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

class CreateSuperAdmin extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'system:create:super';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create super admin';

    public $user;

    /**
     * @inheritdoc
     */
    public function __construct(User $user)
    {
        parent::__construct();
        $this->user = $user;
    }

    /**
     * Execute the console command.
     * @throws \Exception
     */
    public function handle()
    {
        $name = $this->ask('What is your name?');
        $email = $this->ask('What is your email?');
        $password = $this->secret('What is the password?(min: 6 character)');

        $data = [
            'name' => $name,
            'email' => $email,
            'password' => $password,
        ];

        if ($this->register($data)) {
            $this->info('Register a new super admin success! You can login in the hashboard with account:' . $email . ' and password:' . $password);
        } else {
            $this->error('Something went wrong!');
        }
    }

    /**
     * @param array $data
     * @return User|\Illuminate\Database\Eloquent\Model
     * @throws \Exception
     */
    public function register(array $data)
    {
        $validator = Validator::make($data, [
            'name' => 'required|max:255|unique:users',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6',
        ]);

        if (!$validator->passes()) {
            throw new \Exception($validator->errors()->first());
        }

        $model = $this->user->create(array_merge($data, ['is_super' => true]));

        return $model->userExpand()->create([
            'active_at' => time(),
            'avatar' => [
                'id' => 0,
                'url' => config('website.default.avatar')
            ]
        ]);
    }
}
