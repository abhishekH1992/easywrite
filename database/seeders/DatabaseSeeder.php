<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use \App\Models\User;
use \App\Models\Prompt;
use App\Models\Plan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        User::create([
            'fname'     => 'Abhishek',
            'lname'     => 'Honrao',
            'email'     => 'abhishek@test.com',
            'password'  =>  '$2y$10$GXuhFnfOymTwzRQTsY00suhbdxF2GVygbs9C3GTMBsSl2CJ42RE1W', //Password
            'role'      =>  'user'
        ]);

        $prompts = [
            [
                'name'          =>  'Freechat',
                'settings'      =>  json_encode([
                    'model'             =>  'text-davinci-003',
                    'max_tokens'        =>  256,
                    'temperature'       =>  0,
                    'top_p'             =>  1,
                    'frequency_penalty' =>  0.5,
                    'presence_penalty'  =>  0,
                    'stop'              =>  [" Human:", " AI:"]
                ]),
                'pretext'       =>  null,
                'img'           =>  '/assets/images/freechat.svg',
                'slug'          =>  '/model/freechat',
                'placeholder'   =>  'Type a message...',
                'prefix'        =>  null,
                'divider'       =>  null,
                'aiprefix'      =>  null,
                'history'       =>  1,
                'isFreechat'    =>  1,
            ],
            [
                'name'          =>  'Q&A',
                'settings'      =>  json_encode([
                    'model'             =>  'text-davinci-003',
                    'max_tokens'        =>  100,
                    'temperature'       =>  0,
                    'top_p'             =>  1,
                    'frequency_penalty' =>  0,
                    'presence_penalty'  =>  0,
                    'stop'              =>  ["\n"]
                ]),
                'pretext'       =>  'I am a highly intelligent question answering bot. If you ask me a question that is rooted in truth, I will give you the answer. If you ask me a question that is nonsense, trickery, or has no clear answer, I will respond with "Unknown".',
                'img'           =>  '/assets/images/freechat.svg',
                'slug'          =>  '/model/qa',
                'placeholder'   =>  'Ask a question...',
                'prefix'        =>  'Q:',
                'divider'       =>  "\n\n",
                'aiprefix'      =>  'A:',
                'history'       =>  1,
                'isFreechat'    =>  0,
            ],
            [
                'name'          =>  'Grammer Checker',
                'settings'      =>  json_encode([
                    'model'             =>  'text-davinci-003',
                    'max_tokens'        =>  60,
                    'temperature'       =>  0,
                    'top_p'             =>  1,
                    'frequency_penalty' =>  0,
                    'presence_penalty'  =>  0
                ]),
                'pretext'       =>  'Correct this to standard English:',
                'img'           =>  '/assets/images/freechat.svg',
                'slug'          =>  '/model/grammer-checker',
                'placeholder'   =>  'Correct this to standard English..',
                'divider'       =>  "\n\n",
                'style'         =>  'background-color: #d2f4d3',
                'language'      =>  'Use language: British English',
                'history'       =>  1,
                'isFreechat'    =>  0,
                'isTextarea'    =>  1,
            ],
            [
                'name'          =>  'Summary',
                'settings'      =>  json_encode([
                    'model'             =>  'text-davinci-003',
                    'max_tokens'        =>  256,
                    'temperature'       =>  0.7,
                    'top_p'             =>  1,
                    'frequency_penalty' =>  0,
                    'presence_penalty'  =>  0
                ]),
                'pretext'       =>  '<p>Summarize this for a second-grade student:</p>',
                'img'           =>  '/assets/images/freechat.svg',
                'slug'          =>  '/model/summary',
                'divider'       =>  "\n\n",
                'style'         =>  'background-color: #d2f4d3',
                'isTextarea'    =>  1,
                'history'       =>  1,
                'isFreechat'    =>  0,
            ],
            [
                'name'          =>  'Ad from product description',
                'settings'      =>  json_encode([
                    'model'             =>  'text-davinci-003',
                    'max_tokens'        =>  100,
                    'temperature'       =>  0.5,
                    'top_p'             =>  1,
                    'frequency_penalty' =>  0,
                    'presence_penalty'  =>  0
                ]),
                'pretext'       =>  '<p>Write a creative ad for the following product:</p><p>Product title:</p><p>Product description:</p><p>Target audience:</p><p>Tone: Friendly/Proffesional</p>',
                'img'           =>  '/assets/images/freechat.svg',
                'slug'          =>  '/model/ad',
                'divider'       =>  "\n\n",
                'style'         =>  'background-color: #d2f4d3',
                'isTextarea'    =>  1,
                'history'       =>  1,
                'isFreechat'    =>  0,
            ],
            [
                'name'          =>  'Keywords',
                'settings'      =>  json_encode([
                    'model'             =>  'text-davinci-003',
                    'max_tokens'        =>  60,
                    'temperature'       =>  0.5,
                    'top_p'             =>  1,
                    'frequency_penalty' =>  0.8,
                    'presence_penalty'  =>  0
                ]),
                'pretext'       =>  '<p>Extract keywords from following text:</p>',
                'img'           =>  '/assets/images/freechat.svg',
                'slug'          =>  '/model/keywords',
                'divider'       =>  "\n\n",
                'style'         =>  'background-color: #d2f4d3',
                'isTextarea'    =>  1,
                'history'       =>  1,
                'isFreechat'    =>  0,
            ],
            [
                'name'          =>  'Note to summary',
                'settings'      =>  json_encode([
                    'model'             =>  'text-davinci-003',
                    'max_tokens'        =>  256,
                    'temperature'       =>  0.5,
                    'top_p'             =>  1,
                    'frequency_penalty' =>  0,
                    'presence_penalty'  =>  0
                ]),
                'pretext'       =>  '<p>Note:</p>',
                'img'           =>  '/assets/images/freechat.svg',
                'slug'          =>  '/model/note-to-summary',
                'divider'       =>  "\n\n",
                'style'         =>  'background-color: #d2f4d3',
                'isTextarea'    =>  1,
                'history'       =>  1,
                'isFreechat'    =>  0,
            ],
            [
                'name'          =>  'Essay Outline',
                'settings'      =>  json_encode([
                    'model'             =>  'text-davinci-003',
                    'max_tokens'        =>  150,
                    'temperature'       =>  0.3,
                    'top_p'             =>  1,
                    'frequency_penalty' =>  0,
                    'presence_penalty'  =>  0
                ]),
                'pretext'       =>  '<p>Create an outline for an essay</p><p>Topic:</p>',
                'img'           =>  '/assets/images/freechat.svg',
                'slug'          =>  '/model/essay-outline',
                'divider'       =>  "\n\n",
                'style'         =>  'background-color: #d2f4d3',
                'isTextarea'    =>  1,
                'history'       =>  1,
                'isFreechat'    =>  0,
            ],
            [
                'name'          =>  'Interview Questions',
                'settings'      =>  json_encode([
                    'model'             =>  'text-davinci-003',
                    'max_tokens'        =>  150,
                    'temperature'       =>  0.5,
                    'top_p'             =>  1,
                    'frequency_penalty' =>  0,
                    'presence_penalty'  =>  0
                ]),
                'pretext'       =>  '<p>Create a list of questions for my interview:</p><p>Topic:</p><p>No. of Questions:</p>',
                'img'           =>  '/assets/images/freechat.svg',
                'slug'          =>  '/model/interview-question',
                'divider'       =>  "\n\n",
                'style'         =>  'background-color: #d2f4d3',
                'isTextarea'    =>  1,
                'history'       =>  1,
                'isFreechat'    =>  0,
            ],
        ];

        foreach($prompts as $prompt){
            Prompt::create($prompt);
        }

        $plans = [
            [
                'name' => 'Basic', 
                'slug' => 'basic', 
                'stripe_plan' => 'price_1MQ3hsEHrPwcYHIS6YWZz3Ki', 
                'price' => 9.99, 
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.'
            ],
            [
                'name' => 'Advance', 
                'slug' => 'advance', 
                'stripe_plan' => 'price_1MQ3iiEHrPwcYHISg7cmbxdN', 
                'price' => 19.99, 
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.'
            ],
            [
                'name' => 'Premium', 
                'slug' => 'premium', 
                'stripe_plan' => 'price_1MQ3jJEHrPwcYHISnaDz6qEG', 
                'price' => 29.99, 
                'description' => 'Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industrys standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.'
            ]
        ];

        foreach ($plans as $plan) {
            Plan::create($plan);
        }
    }
}
