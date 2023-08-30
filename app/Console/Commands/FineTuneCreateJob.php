<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\ChatSuiteSections;

class FineTuneCreateJob extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'finetune:create:job {chat_suite_sections_id} {model}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fine Tune Create Job.';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $chatSuit = ChatSuiteSections::find($this->argument('chat_suite_sections_id'));

        $data = [
            'training_file' =>  $chatSuit->file_id,
            'model'         =>  $this->argument('model'),
        ];

        $auth = 'Authorization: Bearer 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';
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'https://api.openai.com/v1/fine_tuning/jobs');
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json', $auth));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data, true));
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
        $result = curl_exec($ch);
        curl_close($ch);

        \Log::info(var_export($result, true));

        return Command::SUCCESS;
    }
}
