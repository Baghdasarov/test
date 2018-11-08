<?php

namespace App\Console\Commands;

use App\Jobs\UpdateDatabase;
use Illuminate\Console\Command;

class RunUpdateDatabase extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:update';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create/Update database from Json file';

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
     * @return void
     */
    public function handle()
    {
        dispatch(new UpdateDatabase());
    }
}
