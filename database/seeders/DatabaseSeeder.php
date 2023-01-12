<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use \App\Models\User;
use \App\Models\Prompt;

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
                'aiprefix'      =>  'A:'
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
                'isTextarea'   =>  1
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
                'pretext'       =>  '<p>Summarize this for a second-grade student:</p><br><p>Jupiter is the fifth planet from the Sun and the largest in the Solar System. It is a gas giant with a mass one-thousandth that of the Sun, but two-and-a-half times that of all the other planets in the Solar System combined. Jupiter is one of the brightest objects visible to the naked eye in the night sky, and has been known to ancient civilizations since before recorded history. It is named after the Roman god Jupiter.[19] When viewed from Earth, Jupiter can be bright enough for its reflected light to cast visible shadows,[20] and is on average the third-brightest natural object in the night sky after the Moon and Venus.</p>',
                'img'           =>  '/assets/images/freechat.svg',
                'slug'          =>  '/model/summary',
                'divider'       =>  "\n\n",
                'style'         =>  'background-color: #d2f4d3',
                'isTextarea'   =>  1
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
                'pretext'       =>  '<p>Write a creative ad for the following product to run on Facebook aimed at parents:</p><br><p>Product: Learning Room is a virtual environment to help students from kindergarten to high school excel in school.</p>',
                'img'           =>  '/assets/images/freechat.svg',
                'slug'          =>  '/model/ad',
                'divider'       =>  "\n\n",
                'style'         =>  'background-color: #d2f4d3',
                'isTextarea'   =>  1
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
                'pretext'       =>  '<p>Extract keywords from this text:</p><br><p>Black-on-black ware is a 20th- and 21st-century pottery tradition developed by the Puebloan Native American ceramic artists in Northern New Mexico. Traditional reduction-fired blackware has been made for centuries by pueblo artists. Black-on-black ware of the past century is produced with a smooth surface, with the designs applied through selective burnishing or the application of refractory slip. Another style involves carving or incising designs and selectively polishing the raised areas. For generations several families from Khapo Owingeh and Pohwhóge Owingeh pueblos have been making black-on-black ware with the techniques passed down from matriarch potters. Artists from other pueblos have also produced black-on-black ware. Several contemporary artists have created works honoring the pottery of their ancestors.</p>',
                'img'           =>  '/assets/images/freechat.svg',
                'slug'          =>  '/model/keywords',
                'divider'       =>  "\n\n",
                'style'         =>  'background-color: #d2f4d3',
                'isTextarea'   =>  1
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
                'pretext'       =>  '<p>Convert my short hand into a first-hand account of the meeting:</p><br><p>Tom: Profits up 50%</p><p>Jane: New servers are online</p><p>Kjel: Need more time to fix software</p><p>Jane: Happy to help</p><p>Parkman: Beta testing almost done</p>',
                'img'           =>  '/assets/images/freechat.svg',
                'slug'          =>  '/model/note-to-summary',
                'divider'       =>  "\n\n",
                'style'         =>  'background-color: #d2f4d3',
                'isTextarea'   =>  1
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
                'pretext'       =>  '<p>Create an outline for an essay about Nikola Tesla and his contributions to technology:</p>',
                'img'           =>  '/assets/images/freechat.svg',
                'slug'          =>  '/model/essay-outline',
                'divider'       =>  "\n\n",
                'style'         =>  'background-color: #d2f4d3',
                'isTextarea'   =>  1
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
                'pretext'       =>  '<p>Create a list of 8 questions for my interview with a science fiction author:</p>',
                'img'           =>  '/assets/images/freechat.svg',
                'slug'          =>  '/model/interview-question',
                'divider'       =>  "\n\n",
                'style'         =>  'background-color: #d2f4d3',
                'isTextarea'   =>  1
            ],
        ];

        foreach($prompts as $prompt){
            Prompt::create($prompt);
        }
    }
}
