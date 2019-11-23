<?php

namespace SaadeMotion\Photofolio\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;
use SaadeMotion\Photofolio\Facades\Photofolio;

class AdminCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'photofolio:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create an admin user.';

    /**
     * Get user options.
     */
    protected function getOptions()
    {
        return [
            ['create', null, InputOption::VALUE_NONE, 'Create an admin user', null],
        ];
    }

    public function fire()
    {
        return $this->handle();
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function handle()
    {
        $user = null;

        // Create user
        if ($this->option('create')) {
            $user = $this->createUser();
        } else {
            $this->error('U know what ur doing?');
            exit;
        }

        // the user not returned
        if (!$user) {
            $this->error('Cannot create admin user.');
            exit;
        }
    }

    /**
     * Get command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['email', InputOption::VALUE_REQUIRED, 'The email of the user.', null],
        ];
    }

    /**
     * Get or create user.
     *
     * @param bool $create
     *
     * @return \App\User
     */
    protected function createUser($create = false)
    {
        $email = $this->argument('email');

        $model = Auth::guard('web')->getProvider()->getModel();
        $model = Str::start($model, '\\');

        $name = $this->ask('Enter the admin name');
        $password = $this->secret('Enter admin password');
        $confirmPassword = $this->secret('Confirm Password');

        // Ask for email if there wasnt set one
        if (!$email) {
            $email = $this->ask('Enter the admin email');
        }

        // Passwords don't match
        if ($password != $confirmPassword) {
            $this->info("Passwords don't match");
            return;
        }

        $this->info('Creating admin account');

        return call_user_func($model.'::create', [
            'name'     => $name,
            'email'    => $email,
            'password' => Hash::make($password),
        ]);
    }
}
