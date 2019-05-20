<?php

namespace App\Console\Commands\Temporary;

use App\User;
use Illuminate\Console\Command;

class defaultEnglish extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'temporary:default_english';

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
        $a = User::withAnyStatus()
            ->where('languages', null)
            ->update([
                'languages' => json_encode([39]),
            ]);

        dd($a);
    }
}
