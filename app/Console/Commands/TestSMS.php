<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\SMS\SendbulkSMS;

class TestSMS extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'sms:test {phone} {message}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Test SMS sending via mNotify';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $phone = $this->argument('phone');
        $message = $this->argument('message');

        $this->info('=== SMS Test Debug Info ===');
        $this->info('API URL: ' . config('sms.bulk.api_url'));
        $this->info('Sender Name: ' . config('sms.bulk.sender_name'));
        $this->info('API Key: ' . substr(config('sms.bulk.api_key'), 0, 10) . '...');
        $this->info('Phone: ' . $phone);
        $this->info('Message: ' . $message);
        $this->info('=========================');

        $result = SendbulkSMS::sendBulkMessage($message, $phone);

        if ($result) {
            $this->info('Response: ' . json_encode($result, JSON_PRETTY_PRINT));

            if (isset($result->code)) {
                $status = SendbulkSMS::status($result->code);
                $this->info('Status: ' . $status);
            }
        } else {
            $this->error('Failed to send SMS - No response received');
        }

        return 0;
    }
}