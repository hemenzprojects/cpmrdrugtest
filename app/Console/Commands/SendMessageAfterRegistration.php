<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Product;
use App\Admin;
use App\SMS\SendSMS;


class SendMessageAfterRegistration extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'customer:registration';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'send customer notification after registration';

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
        
        
    }
}
