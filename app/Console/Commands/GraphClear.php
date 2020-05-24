<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Graph;

class GraphClear extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'graphs:clear';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Clear all graphs';

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
        if($this->confirm('Do you wish to continue?',true)){
            // Delete all records
            Graph::truncate();
            $this->info("Process terminated");
        }{
            $this->info("Process canceled");
        }
        
    }
}
