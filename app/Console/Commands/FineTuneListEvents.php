<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class FineTuneListEvents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'finetune:list:events {ft_id}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'List of fine tune evnets';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $auth = 'Authorization: Bearer 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';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.openai.com/v1/fine_tuning/jobs/'.$this->argument('ft_id').'/events');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $auth));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $result = curl_exec($ch);
        curl_close($ch);
        $result = json_decode($result);
        \Log::info(var_export($result, true));

        return Command::SUCCESS;
    }
}
