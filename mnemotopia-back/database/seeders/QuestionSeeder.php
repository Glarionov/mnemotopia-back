<?php

namespace Database\Seeders;

use App\Factories\ModelWithTextFactory;
use App\Models\Question;
use App\Services\Group\QuestionService;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QuestionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $service = new QuestionService();

        $options = [
            ['text' => 'correct', 'correct' => true],
            ['text' => 'incorrect', 'correct' => false],
        ];
        $service->storeByParams(['group_id' => 1, 'text' => 'q1', 'type' => 1, 'options' => $options]);
        $service->storeByParams(['group_id' => 1, 'text' => 'q2', 'type' => 1, 'options' => $options]);


        $text = 'A <qpart badOptions="Z|||Y">B</qpart> C <qpart badOptions="N|||M">D</qpart> E';
        $service->storeByParams(['group_id' => 1, 'text' => $text, 'type' => 2]);
    }
}
