<?php

namespace App\Http\Controllers\Questions;

use App\Factories\ModelWithTextFactory;
use App\Http\Controllers\Controller;
use App\Http\Requests\GroupUpdateOrCreateRequest;
use App\Http\Requests\InstanceWithTextRequest;
use App\Interfaces\Group\GroupServiceInterface;
use App\Models\ChainElements;
use App\Models\Group;
use App\Models\QPart;
use App\Services\Group\GroupService;
use Illuminate\Http\Request;

class GroupController extends Controller
{
    public function __construct(public GroupService $mainService)
    {}

    /**
     * @OA\Get(
     *      path="/groups",
     *      tags={"groups"},
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              type="object",
     *          ),
     *      ),
     * )
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return $this->mainService->list();
    }

    public function getGroupByParentId($parentId = null)
    {
        $groups = Group::query()->where('groups.parent_group_id', '=', $parentId)->get();
        $result = [];

        $this->mainService->textAdder->addTexts($groups);

        foreach ($groups->toArray() as $groupIndex => $group) {
            $result[$groupIndex] = [
                'group' => $group,
                'child_groups' => $this->getGroupByParentId($group['id'])
            ];
        }

        return $result;
    }

    private static function addDataToArray($data, &$result)
    {
        foreach ($data as $datum) {
            $result[$datum['id']] = $datum;
        }
    }

    private function addQuestionData($questions, &$result)
    {
        $questions = $questions['questions'];
        $this->mainService->textAdder->addTexts($questions);

        foreach ($questions as $question) {
            $questionData = [
                'id' => $question['id'],
                'text' => $question['text'],
                'type' => $question['type'],
                'showingText' => $question['text'],
            ];
            $questionId = $question['id'];
            self::addDataToArray($question['options'], $result['options']);

            if ($question['type'] == 1) {
                $questionData['correctAnswers'] = [];
                $questionData['incorrectAnswers'] = [];

                foreach ($result['options'] as $option) {
                    if ($option['pivot']['correct']) {
                        $questionData['correctAnswers'][] = $option['id'];
                    } else {
                        $questionData['incorrectAnswers'][] = $option['id'];
                    }
                }
            } elseif ($question['type'] == 2) {

//                'text' => $question['text'],

                $text = $question['text'];

                $pattern = '#<qpart.*?</qpart>#';

                $replaced = preg_replace($pattern, '#QPART#_THIS_IS_PART_#QPART#', $text);

                $text = explode('#QPART#', $replaced);


                $qparts = QPart::query()->where('question_id', '=', $questionId)
                    ->with('options')->get();

                $questionData['parts'] = [];

                $shift = $text[0] == '_THIS_IS_PART_'? 0: 1;


                $partsArray = $qparts->toArray();

                foreach ($partsArray as $partIndex => $qpart) {
                    self::addDataToArray($qpart['options'], $result['options']);
                    $id = $qpart['id'];

//                    $text[$partIndex + $shift] = $id;
//
//                    $shift++;

                    $partData = [];

                    foreach ($qpart['options'] as $option) {
                        if ($option['pivot']['correct']) {
                            $partData['correctAnswers'][] = $option['id'];
                        } else {
                            $partData['incorrectAnswers'][] = $option['id'];
                        }
                    }

                    $questionData['parts'][$id] = $partData;
                }

                foreach ($text as $textIndex => $textPart) {
                    if ($textPart == '_THIS_IS_PART_') {
                        $text[$textIndex] = array_shift($partsArray)['id'];
                    }
                }

                $questionData['text'] = $text;

                $questionData['partIds'] = $qparts->pluck('id')->toArray();
            }

            $result['questions'][$question['id']] = $questionData;
        }
    }

    public function getGroupWithQuestionsByParentId($parentId = null, &$result = [])
    {
        $groups = Group::query()->where('groups.parent_group_id', '=', $parentId)
            ->with('questions.options')->with('chains.chainElements.questions.options')->get();

//        $result = $groups;
//        return $groups;
//        $questions = $groups->pluck('questions');
//        /*s*/echo '$questions= <pre>' . print_r($questions, true). '</pre>'; //todo r
//        return 1;
//        $result['questions'] = array_merge($result['questions'], $groups->pluck('questions'));
//        $result['chains'] = array_merge($result['chains'], $groups->pluck('chains'));


//        $this->tex
        foreach ($groups as $groupIndex => $group) {
//            /*s*/echo '$group= <pre>' . print_r($group->toArray(), true). '</pre>'; //todo r

//            if ($group?->chains?->chainElements?->questions) {
//            if ($group?->chains) {
////                /*s*/echo '$group->chains->chainElements->questions= <pre>' . print_r($group->chains->chainElements->questions, true). '</pre>'; //todo r
//
//            }
        }

//        $a = [['text_id' => 1]];
//        $this->mainService->textAdder->addTexts($a);
//        /*s*/echo '$a= <pre>' . print_r($a, true). '</pre>'; //todo r
//        return 1;

        $this->mainService->textAdder->addTexts($groups);


        foreach ($groups->toArray() as $groupIndex => $group) {

//            /*s*/echo '$group= <pre>' . print_r($group, true). '</pre>'; //todo r
//            return 1;
//            exit;//todo r


//            {
//                chains: [[[1], [4]]],
//                sharedAnswers: true,
//                freeQuestions: [],
//                options: [1, 2, 3, 4, 5, 6]
//            },

            $groupData = [
                'text' => $group['text'],
                'sharedAnswers' => $group['sharedAnswers'] ?? false,
                'freeQuestions' => [],
                'options' => [],
                'chains' => []
            ];

//            $result['groups'][] = $groupData;
//            continue;//todo r
            $nonFreeQuestions = [];

            if (!empty($group['chains'])) {

//                /*g*/echo 'l='.__LINE__.' t=|'.date('d-m-Y h:i:s'). 'm='. number_format(memory_get_usage(true),0,'.',' ') . '| me='.__METHOD__."\n"; //todo remove it

                foreach ($group['chains'] as $chain) {

                    $chainData = [];
//                    /*g*/echo 'l='.__LINE__.' t=|'.date('d-m-Y h:i:s'). 'm='. number_format(memory_get_usage(true),0,'.',' ') . '| me='.__METHOD__."\n"; //todo remove it
//
//                    /*s*/echo '$chain= <pre>' . print_r($chain, true). '</pre>'; //todo r

                    if (!empty($chain['chain_elements'])) {
//                        /*g*/echo 'l='.__LINE__.' t=|'.date('d-m-Y h:i:s'). 'm='. number_format(memory_get_usage(true),0,'.',' ') . '| me='.__METHOD__."\n"; //todo remove it

                        foreach ($chain['chain_elements'] as $chainElement) {
                            $chainElementData = [];
//                            /*g*/echo 'l='.__LINE__.' t=|'.date('d-m-Y h:i:s'). 'm='. number_format(memory_get_usage(true),0,'.',' ') . '| me='.__METHOD__."\n"; //todo remove it
//
//                            /*s*/echo '$chainElement= <pre>' . print_r($chainElement, true). '</pre>'; //todo r

                            if (!empty($chainElement['questions'])) {
                                $chainElementData = array_column($chainElement['questions'], 'id');
//                                $result['questions'] = array_merge($result['questions'], $chainElement['questions']);

//                                $result['questions'] += $chainElement['questions'];

                                self::addDataToArray($chainElement['questions'], $nonFreeQuestions);
//                                $group
//                                /*g*/echo 'l='.__LINE__.' t=|'.date('d-m-Y h:i:s'). 'm='. number_format(memory_get_usage(true),0,'.',' ') . '| me='.__METHOD__."\n"; //todo remove it

                                $questions = $result['questions'];

                                $this->addQuestionData($chainElement, $result);

//                                self::addQuestionsToResult($chainElement['questions'], $result['questions']);
                                $chainData[] = $chainElementData;
                            }


                        }

                        if (!empty($chainData)) {
                            $groupData['chains'][] = $chainData;
                        }

                    }
                }
            }

            $questions = $group['questions'];
            $nonFreeQuestions = array_keys($nonFreeQuestions);

            $questions = array_filter($questions, function ($question) use ($nonFreeQuestions) {
                return !in_array($question['id'], $nonFreeQuestions);
            });

            $groupData['freeQuestions'] = array_column($questions, 'id');
            $result['groups'][] = $groupData;
//            $result['groups'][$group['id']] = $groupData;

            $this->addQuestionData($group, $result);

            $this->mainService->textAdder->addTexts($result['options']);

            $this->getGroupWithQuestionsByParentId($group['id'], $result);
        }
    }

    /**
     * @OA\Get(
     *     path="/groups/get-tree",
     *     tags={"Groups"},
     *     @OA\Parameter(
     *           name="parent_group_id",
     *           @OA\Schema(type="integer"),
     *           in="query"
     *         ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              type="object",
     *          ),
     *      ),
     * )
     * @return array
     */
    public function getTree(Request $request): array
    {
        $parentId = $request->input('parent_group_id', null);

        $tree = $this->getGroupByParentId($parentId);
        $this->mainService->textAdder->addTexts();
        return $tree;
    }

    public function loadQuestionsByGroupTree($tree, &$result = [])
    {
        foreach ($tree as $branch) {
            $groupId = $branch['group']['id'];

            $result[$groupId] = $groupId;

            if (!empty($branch['child_groups'])) {
                $this->loadQuestionsByGroupTree($branch['child_groups'], $result);
            }

        }
    }

    /**
     * @OA\Get(
     *     path="/groups/get-questions",
     *     tags={"Groups"},
     *     @OA\Parameter(
     *           name="parent_group_id",
     *           @OA\Schema(type="integer"),
     *           in="query"
     *         ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              type="object",
     *          ),
     *      ),
     * )
     * @return array
     */
    public function getGroupQuestions(Request $request)
    {
        $parentId = $request->input('parent_group_id', null);

        $result = [
            'groups' => [],
            'questions' => [],
            'chains' => [],
            'options' => [],
        ];

        $this->getGroupWithQuestionsByParentId($parentId, $result);

//        $tree =  $this->getGroupByParentId($parentId);



        return $result;
    }

    /**
     * @OA\Post(
     *     path="/groups",
     *     tags={"Groups"},
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="text", type="string"),
     *              @OA\Property(property="shared_answers", type="boolean"),
     *              @OA\Property(property="parent_group_id", type="integer"),
     *            )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              type="object",
     *          ),
     *      ),
     * )
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \App\Models\AbstractModelWithText
     */
    public function store(GroupUpdateOrCreateRequest $request)
    {
        $text = $request->input('text');
        $params = [];

        $params['parent_group_id'] = $request->input('parent_group_id', null);
        $params['shared_answers'] = $request->input('shared_answers', false);

        $newGroup = ModelWithTextFactory::create(Group::class, $text, $params);
        return $newGroup;
    }

    /**
     * @OA\Get (
     *     path="/groups/{group}",
     *     tags={"groups"},
     *     @OA\Parameter(
     *           name="group",
     *           @OA\Schema(type="integer"),
     *           in="path"
     *         ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              type="object",
     *          ),
     *      ),
     * )
     * Display the specified resource.
     *
     * @param  \App\Models\ChainElements  $chainElement
     * @return \Illuminate\Http\Response
     */
    public function show(Group $group)
    {
        return $this->mainService->show($group);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * @OA\Patch  (
     *     path="/groups/{group}",
     *     tags={"groups"},
     *     @OA\Parameter(
     *           name="group",
     *           @OA\Schema(type="integer"),
     *           in="path"
     *         ),
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="text", type="string"),
     *            )
     *      ),
     *      @OA\Response(
     *          response=200,
     *          description="Success",
     *          @OA\JsonContent(
     *              type="object",
     *          ),
     *      ),
     * )
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\ChainElements  $chainElement
     * @return \Illuminate\Http\Response
     */
    public function update(GroupUpdateOrCreateRequest $request, Group $group)
    {
        return $this->mainService->update($request, $group);
    }

    /**
    * @OA\Delete (
    *     path="/groups/{group}",
    *     tags={"groups"},
    *     @OA\Parameter(
    *           name="group",
    *           @OA\Schema(type="integer"),
    *           in="query"
    *         ),
    *      @OA\Response(
    *          response=200,
    *          description="Success",
    *          @OA\JsonContent(
    *              type="object",
    *          ),
    *      ),
    * )
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($group)
    {
        return $this->mainService->destroy($group);
    }
}
