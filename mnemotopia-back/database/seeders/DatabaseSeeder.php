<?php

namespace Database\Seeders;

use App\Models\ChainElements;
use App\Models\Group;
use App\Models\Text;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $texts = Text::factory()
            ->count(1)
            ->create();

        $groups = Group::factory()
            ->count(1)
            ->create();

        $LangugeSeeder = new LanguageSeeder();
        $LangugeSeeder->run();

        $TextByLanguage = new TextByLanguageSeeder();
        $TextByLanguage->run();

        $seeder = new ChainsSeeder();
        $seeder->run();

        $seeder = new ChainElementsSeeder();
        $seeder->run();

        $seeder = new QuestionSeeder();
        $seeder->run();

        // \App\Models\User::factory(10)->create();
    }
}
