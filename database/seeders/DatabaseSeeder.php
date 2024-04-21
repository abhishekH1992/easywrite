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
                'vip'       =>  1
            ],
            [
                'fname'     =>  'Mathew',
                'lname'     =>  'Fesilie',
                'email'     =>  'matt@moanadigitalsolutions.com',
                'password'  =>  '$2y$10$GXuhFnfOymTwzRQTsY00suhbdxF2GVygbs9C3GTMBsSl2CJ42RE1W', //Password
                'role'      =>  'admin',
                'vip'       =>  1
            ],
            [
                'fname'     =>  'Ankita',
                'lname'     =>  'Kaushik',
                'email'     =>  'ankita@gmail.com',
                'password'  =>  '$2y$10$GXuhFnfOymTwzRQTsY00suhbdxF2GVygbs9C3GTMBsSl2CJ42RE1W', //Password
                'role'      =>  'admin',
                'vip'       =>  1
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

        $prompt = [
            [
                'name'          =>  'Talanoa Law',
                'slug'          =>  '/model/talanoa-law',
                'placeholder'   =>  'Type a message...',
                'img'           =>  '/assets/images/freechat.svg',
                'isFreechat'    =>  1,
                'background'    =>  '#dd5ce5',
                'template'      =>  'Legal AI',
                'endpoint'      =>  '/api/law_bot/chat',
                'isPython'      =>  1,
                'isWebpage'     =>  1,
                'isMenu'        =>  1,
            ],
            [
                'name'          =>  'Talanoa Law 2.0',
                'slug'          =>  '/model/talanoa-law-2',
                'placeholder'   =>  'Type a message...',
                'img'           =>  '/assets/images/freechat.svg',
                'isFreechat'    =>  1,
                'background'    =>  '#dd5ce5',
                'template'      =>  'Legal AI',
                'endpoint'      =>  '/api/hybrid_law_bot/chat',
                'isPython'      =>  1,
                'isWebpage'     =>  1,
                'isMenu'        =>  1,
            ]
        ];

        Prompt::insert($prompt);

        Plan::create([
            'name'          =>  'Basic',
            'slug'          =>  'basic',
            'stripe_plan'   =>  'price_1MSPwWJHEmokClBErlPd7ErM',
            'price'         =>  9.99,
            'description'   =>  'Introductory Offer: Get started with our Basic Plan at a special launch price of $9.99. You will receive a 3-day trial free of charge; we only charge after the trial period has ended.'
        ]);
    }
}
