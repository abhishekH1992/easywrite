<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use OpenAI;

class FineTuneListJobs extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'finetune:list:jobs';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Get a list of jobs';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $client = OpenAI::client('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');

        //Not working
        $response = $client->fineTunes()->listJobs();

        \Log::info($response->toArray());

        return Command::SUCCESS;
    }
}
