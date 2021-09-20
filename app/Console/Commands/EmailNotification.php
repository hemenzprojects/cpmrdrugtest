<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Mail\SendBackup;
use Illuminate\Support\Facades\Mail;

class EmailNotification extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'database:sendbackup';

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
        //
        Mail::to('databasebackup@cpmr.org.gh')->send(new SendBackup);
        $this->info('done');

    }
}
