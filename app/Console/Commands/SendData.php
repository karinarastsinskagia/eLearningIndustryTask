<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Http\Controllers\ExternalServiceController;

class SendData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'external-service:send-data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send all existing article records in our database to external service';

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
     * @return int
     */
    public function handle()
    {
       
        $controller = new ExternalServiceController();
        $controller->sendAll();
        return 0;
    }
}
