<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use OpenAI;

use App\Models\ChatSuiteSections;

class FineTuneFileUpload extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'finetune:file:upload {filepath}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Uplaod JSONL format file for fine tune';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(){
        $client = OpenAI::client('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');

        $filepath = storage_path('app/public/finetune/'.$this->argument('filepath'));

        $response = $client->files()->upload([
            'purpose'   =>  'fine-tune',
            'file'      =>  fopen($filepath, 'r'),
        ]);

        \Log::info($response->toArray());

        // ChatSuiteSections::create([
        //     'name'          =>  $this->argument('name'),
        //     'slug'          =>  $this->argument('slug'),
        //     'outline'       =>  $this->argument('outline'),
        //     'chat_suite_id' =>  $this->argument('chat_suite_id'),
        //     'file_id'       =>  $response->id,
        // ]);

        return Command::SUCCESS;
    }
}
