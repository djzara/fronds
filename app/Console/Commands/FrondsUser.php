<?php

namespace Fronds\Console\Commands;

use Fronds\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Str;

class FrondsUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fronds:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new user within fronds';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() : void
    {
        $this->warn('Creating a Fronds user...');
        $userName = $this->ask('Name?');
        $userEmail = $this->ask('Email?');
        $userPass = $this->secret('Password?');
        $user = new User();
        $user->name = $userName;
        $user->email = $userEmail;
        $user->password = bcrypt($userPass);
        $user->fronds_folder_key = Str::snake(strtolower($userName)) .'/'. time();
        $user->save();
        $this->info(sprintf('User created with id %s, and folder key %s', $user->id, $user->fronds_folder_key));
    }
}
