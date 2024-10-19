<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class UserAddCommand extends Command
{
    protected $signature = 'user:create {name} {email} {password}';

    protected $description = 'Создание пользователя';

    public function handle()
    {
        User::create([
            'name' => $this->argument('name'),
            'email' => $this->argument('email'),
            'password' => bcrypt($this->argument('password')),
        ]);
    }
}
