<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use \App\Models\User;
use \App\Models\Prompt;
use App\Models\Plan;
use App\Models\Language;
use App\Models\Tone;
use App\Models\TranslateLanguage;
use App\Models\CountryCourt;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            [
                'fname'     =>  'Abhishek',
                'lname'     =>  'Honrao',
                'email'     =>  'abhishek@test.com',
                'password'  =>  '$2y$10$GXuhFnfOymTwzRQTsY00suhbdxF2GVygbs9C3GTMBsSl2CJ42RE1W', //Password
                'role'      =>  'admin',
                'vip'       =>  1,
                'email_verified_at'  =>  now(),
            ],
            [
                'fname'     =>  'Mathew',
                'lname'     =>  'Fesilie',
                'email'     =>  'matt@moanadigitalsolutions.com',
                'password'  =>  '$2y$10$GXuhFnfOymTwzRQTsY00suhbdxF2GVygbs9C3GTMBsSl2CJ42RE1W', //Password
                'role'      =>  'admin',
                'vip'       =>  1,
                'email_verified_at'  =>  now(),
            ],
            [
                'fname'     =>  'Ankita',
                'lname'     =>  'Kaushik',
                'email'     =>  'ankita@gmail.com',
                'password'  =>  '$2y$10$GXuhFnfOymTwzRQTsY00suhbdxF2GVygbs9C3GTMBsSl2CJ42RE1W', //Password
                'role'      =>  'admin',
                'vip'       =>  1,
                'email_verified_at'  =>  now(),
            ]
        ];

        User::insert($user);

        $translateLanguage = [
            [
                'name'  =>  'Samoan',
                'code'  =>  'sm'
            ],
            [
                'name'  =>  'Maori',
                'code'  =>  'mi'
            ],
        ];

        TranslateLanguage::insert($translateLanguage);

        $prompts = [
            [
                'name'          =>  'Chat',
                'slug'          =>  '/model/chat',
                'settings'      =>  '{"model":"gpt-4-0125-preview","max_tokens":3500,"temperature":0.7,"top_p":1,"frequency_penalty":0.5,"presence_penalty":0.5,"stop":["Human:"," AI:"]}',
                'placeholder'   =>  'Start by typing "Generate me a ..." or "Write me a ..."',
                'img'           =>  'fa fa-comment',
                'isFreechat'    =>  1,
                'background'    =>  '#dd5ce5',
                'template'      =>  'Conversational AI',
                'isMenu'        =>  1,
                'history'     =>  1,
                'isFreechat'    =>  1,
                'outline'       =>  'Engage with arloplus.com for prompt answers, help, or conversation to fulfill your writing requirements efficiently.',
            ],
            [
                'name'          =>  'Chat 2.0',
                'slug'          =>  '/model/chat-2.0',
                'placeholder'   =>  'Start by typing "Generate me a ..." or "Write me a ..."',
                'img'           =>  'fa-solid fa-comments',
                'isFreechat'    =>  1,
                'background'    =>  '#dd5ce5',
                'template'      =>  'Conversational AI',
                'isMenu'        =>  1,
                'isFreechat'    =>  1,
                'endpoint'      =>  '/api/chat_2',
                'isPython'      =>  1
            ],
            [
                'name'          =>  'Chat 3.0',
                'slug'          =>  '/model/chat-3.0',
                'placeholder'   =>  'Start by typing "Generate me a ..." or "Write me a ..."',
                'img'           =>  'fas fa-comment-dots',
                'isFreechat'    =>  1,
                'background'    =>  '#dd5ce5',
                'template'      =>  'Conversational AI',
                'isMenu'        =>  1,
                'isFreechat'    =>  1,
                'endpoint'      =>  '/api/web_gpt/chat',
                'isPython'      =>  1
            ],
            [
                'name'          =>  'ARLO Law 2.0',
                'slug'          =>  '/model/arlo-law-2',
                'placeholder'   =>  'Type a message...',
                'img'           =>  'fas fa-graduation-cap',
                'isFreechat'    =>  1,
                'background'    =>  '#dd5ce5',
                'template'      =>  'Legal AI',
                'endpoint'      =>  '/api/hybrid_law_bot/chat',
                'isPython'      =>  1,
                'isWebpage'     =>  1,
                'isMenu'        =>  1,
            ],
            [
                'name'          =>  'ARLO Law 3.0',
                'slug'          =>  '/model/arlo-law-3',
                'placeholder'   =>  'Type a message...',
                'img'           =>  'fa fa-legal',
                'isFreechat'    =>  1,
                'background'    =>  '#dd5ce5',
                'template'      =>  'Legal AI',
                'endpoint'      =>  '/api/multi_source_law_bot/chat',
                'isPython'      =>  1,
                'isWebpage'     =>  1,
                'isMenu'        =>  1,
                'country_court_endpoint'    =>  '/api/multi_source_law_bot/change_source'
            ],
            [
                'name'          =>  'Speech To Text',
                'slug'          =>  '/speech-to-text',
                'settings'      =>  '{"model":"gpt-4-0125-preview","max_tokens":4000,"temperature":0.7,"top_p":1,"frequency_penalty":0.5,"presence_penalty":0.5,"stop":["Human:"," AI:"]}',
                'placeholder'   =>  'Ask about audio...',
                'img'           =>  'fa fa-volume-up',
                'isFreechat'    =>  0,
                'background'    =>  '#dd5ce5',
                'template'      =>  'Workspace',
                'isMenu'        =>  1,
                'history'     =>  1,
                'isFreechat'    =>  1,
                'is_display_in_list'    =>  1,
            ],
            [
                'name'          =>  'Text Completion',
                'slug'          =>  '/model/text-completion',
                'img'           =>  'fa fa-paste',
                'isFreechat'    =>  1,
                'background'    =>  '#dd5ce5',
                'template'      =>  'Workspace',
                'isMenu'        =>  1,
                'isFreechat'    =>  1,
                'endpoint'      =>  '/api/suggest',
                'isPython'      =>  1,
                'isPythonSuggestions'      =>  1,
            ],
        ];

        foreach($prompts as $prompt) {
            Prompt::create($prompt);
        }

        Plan::create([
            'name'          =>  'Basic',
            'slug'          =>  'basic',
            'stripe_plan'   =>  'price_1MSPwWJHEmokClBErlPd7ErM',
            'price'         =>  9.99,
            'description'   =>  'Introductory Offer: Get started with our Basic Plan at a special launch price of $9.99. You will receive a 3-day trial free of charge; we only charge after the trial period has ended.'
        ]);

        $data = '[{"country": "American Samoa", "courts": ["American Samoa High Court"]}, {"country": "CNMI", "courts": ["CNMI Supreme Court"]}, {"country": "Cook Islands", "courts": ["Cook Islands High Court - Land Division", "Cook Islands Court of Appeal", "Cook Islands High Court", "United Kingdom Privy Council - Decisions for Cook Islands"]}, {"country": "FSM", "courts": ["FSM Supreme Court", "Chuuk State Court", "Pohnpei State Court", "Kosrae State Court", "Yap State Court"]}, {"country": "Fiji", "courts": ["Fiji Court of Appeal", "Fiji Magistrates Court", "Fiji High Court - Family Division", "Fiji Supreme Court", "Fiji High Court"]}, {"country": "Guam", "courts": ["Guam Supreme Court"]}, {"country": "Kiribati", "courts": ["Kiribati Court of Appeal", "Kiribati High Court", "Kiribati Magistrates Court"]}, {"country": "Marshall Islands", "courts": ["Marshall Islands High Court", "Marshall Islands Traditional Rights Court", "Marshall Islands Supreme Court"]}, {"country": "Nauru", "courts": ["High Court of Australia - Decisions relating to Nauru", "Nauru Court of Appeal", "Nauru Supreme Court", "Nauru District Court"]}, {"country": "New Zealand", "courts": ["Employment Court of New Zealand 1988-", "Courts Martial Appeal Court of New Zealand 1972-", "High Court of New Zealand 1847-", "Family Court of New Zealand 1997-", "Court of Appeal of New Zealand 1888-", "Supreme Court of New Zealand 2004-", "District Court of New Zealand 1981-", "Environment Court of New Zealand 1996-"]}, {"country": "Niue", "courts": ["Niue High Court", "Niue Court of Appeal"]}, {"country": "Palau", "courts": ["Palau Supreme Court"]}, {"country": "Papua New Guinea", "courts": ["Papua New Guinea Coroners Court", "Papua New Guinea District Court", "Papua New Guinea Local Land Court", "Papua New Guinea Provincial Land Court", "Papua New Guinea National Court", "Papua New Guinea Supreme Court"]}, {"country": "Pitcairn Islands", "courts": ["Judicial Committee of Privy Council - Decisions for Pitcairn Islands", "Pitcairn Islands Court of Appeal", "Pitcairn Islands Supreme Court"]}, {"country": "Samoa", "courts": ["Samoa Alcohol and Drugs Court", "Samoa Supreme Court", "Samoa Family Violence Court", "Samoa District Court", "Samoa Youth Court", "Samoa Magistrates Court", "Samoa Family Court", "Samoa Court of Appeal"]}, {"country": "Solomon Islands", "courts": ["United Kingdom Privy Council Decisions for Solomon Islands", "Solomon Islands Local Court", "Solomon Islands Court of Appeal", "Solomon Islands High Court", "Solomon Islands Customary Land Appeal Court", "Solomon Islands Magistrates Court"]}, {"country": "Tokelau", "courts": ["High Court of Tokelau"]}, {"country": "Tonga", "courts": ["Tonga Magistrates Court", "Tonga Supreme Court", "Tonga Land Court", "Tonga Privy Council", "Tonga Court of Appeal"]}, {"country": "Tuvalu", "courts": ["Tuvalu Court of Appeal", "Tuvalu Senior Magistrates Court", "Tuvalu High Court"]}, {"country": "Vanuatu", "courts": ["Vanuatu Magistrates Court", "Vanuatu Supreme Court", "Island Courts of Vanuatu", "Vanuatu Court of Appeal"]}]';

        $data = json_decode($data, true);

        foreach($data as $items) {
            foreach($items['courts'] as $item) {
                CountryCourt::create([
                    'country'   =>  $items['country'],
                    'court'     =>  $item
                ]);
            }
        }
    }
}
