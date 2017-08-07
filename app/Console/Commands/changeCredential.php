<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class changeCredential extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'passwd';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
    public function handle()
    {
        $user_id = $this->ask("user id");
        $user=User::find($user_id);
        $passwd = $this->ask("password");
        $user->password= bcrypt($passwd);
//        $phone = $this->ask("phone");
//        $user->phone= $phone;
        $user->save();
    }
}
