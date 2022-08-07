<?php

namespace App\Services\Group;

use App\Factories\ModelWithTextFactory;
use App\Interfaces\Group\GroupServiceInterface;
use App\Interfaces\Group\QuestionsServiceInterface;
use App\Models\Group;
use App\Models\Qoptions;
use App\Models\QPart;
use App\Models\Question;
use App\Models\Text;
use App\Models\TextByLanguage;
use App\Services\ModelWithText\TextAdder;
use Illuminate\Support\Facades\DB;

class QuestionService extends AbstractServiceWithText implements QuestionsServiceInterface
{

    public function __construct(TextAdder $textAdder = new TextAdder())
    {
        parent::__construct(Question::class, $textAdder);
    }

    public function list($params = [])
    {
        $result = Question::query()->get();

        $this->textAdder->addObjectsNeedingTexts($result);
        $this->textAdder->addTexts();

        return $result;
    }

    public function store($request)
    {
        return $this->storeByParams($request->all());
    }

    public function storeByParams($params = [])
    {
        $text = $params['text'] ?? '';
        $type = $params['type'] ?? 1;
        $options = $params['options'] ?? [];
        $groupId = $params['group_id'] ?? null;
        $chainElementId = $params['chain_element_id'] ?? null;

        $newQuestion = ModelWithTextFactory::create(Question::class, $text, ['type' => $type]);

        $questionId = $newQuestion->id;
        if ($type == 2) {

            $pattern = '#<qpart.*?</qpart>#';

            preg_match_all('#<qpart.*?</qpart>#', $text, $matches);
            $replaced = preg_replace($pattern, '#QPART##QPART#', $text);

            if (!empty($matches)) {
                $position = 0;
                foreach ($matches[0] as $qpart) {
                    $position++;

                    $qpartId = QPart::updateOrCreate(['position' => $position, 'question_id' => $questionId])->id;

                    preg_match('#<qpart.*?badOptions="(.*?)".*>(.*?)</\s*qpart\s*>#', $qpart, $badOptionsMatches);
                    $badOptionsArray = explode('|||', $badOptionsMatches[1]);
                    foreach ($badOptionsArray as $text) {
                        $option = ModelWithTextFactory::create(Qoptions::class, $text);
                        $optionId = $option->id;

                        $insetData = ['qpart_id' => $qpartId, 'qoption_id' => $optionId, 'correct' => false];
                        DB::table('qparts_answers')->insert($insetData);
                    }

                    $answersArray = explode('|||', $badOptionsMatches[2]);

                    foreach ($answersArray as $text) {
                        $option = ModelWithTextFactory::create(Qoptions::class, $text);
                        $optionId = $option->id;

                        $insetData = ['qpart_id' => $qpartId, 'qoption_id' => $optionId, 'correct' => true];
                        DB::table('qparts_answers')->insert($insetData);
                    }
                }
            }

        } else {
            foreach ($options as $qoption) {
                $option = ModelWithTextFactory::create(Qoptions::class, $qoption['text']);
                $optionId = $option->id;

                $insetData = ['question_id' => $questionId, 'qoption_id' => $optionId, 'correct' => $qoption['correct']];
                DB::table('question_answers')->insert($insetData);
            }
        }

        if ($groupId) {
            $newId = DB::table('questions_groups')->insertGetId([
                'question_id' => $questionId,
                'group_id' => $groupId,
                "created_at" =>  \Carbon\Carbon::now(),
                "updated_at" => \Carbon\Carbon::now(),
            ]);
        }

        if ($chainElementId) {
            $newId = DB::table('chain_elements_questions')->insertGetId([
                'question_id' => $questionId,
                'chain_elements_id' => $chainElementId,
                "created_at" =>  \Carbon\Carbon::now(),
                "updated_at" => \Carbon\Carbon::now(),
            ]);
        }

        return $newQuestion;
    }
}
