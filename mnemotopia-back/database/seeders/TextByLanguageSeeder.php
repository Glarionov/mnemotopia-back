<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TextByLanguageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $englishTextId = 2;
        $englishLanguageId = 1;

        $russianTextId = 3;
        $russianLanguageId = 2;

        $testGroupTextId = 1;

        DB::table('text_by_languages')->insert([
        [
            'text_id' => $englishTextId,
            'language_id' => $englishLanguageId,
            'text' => 'English',
            "created_at" =>  \Carbon\Carbon::now(),
            "updated_at" => \Carbon\Carbon::now(),
        ],
            [
                'text_id' => $russianTextId,
                'language_id' => $englishLanguageId,
                'text' => 'Russian',
                "created_at" =>  \Carbon\Carbon::now(),
                "updated_at" => \Carbon\Carbon::now(),
            ],
            [
                'text_id' => $englishTextId,
                'language_id' => $russianLanguageId,
                'text' => 'Английский',
                "created_at" =>  \Carbon\Carbon::now(),
                "updated_at" => \Carbon\Carbon::now(),
            ],
            [
                'text_id' => $russianTextId,
                'language_id' => $russianLanguageId,
                'text' => 'Русский',
                "created_at" =>  \Carbon\Carbon::now(),
                "updated_at" => \Carbon\Carbon::now(),
            ],
            [
                'text_id' => $testGroupTextId,
                'language_id' => $englishLanguageId,
                'text' => 'TestGroup',
                "created_at" =>  \Carbon\Carbon::now(),
                "updated_at" => \Carbon\Carbon::now(),
            ],
            [
                'text_id' => $testGroupTextId,
                'language_id' => $russianLanguageId,
                'text' => 'Тестогруппа',
                "created_at" =>  \Carbon\Carbon::now(),
                "updated_at" => \Carbon\Carbon::now(),
            ],
            ]);
    }
}
