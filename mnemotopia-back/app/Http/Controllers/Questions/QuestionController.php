<?php

namespace App\Http\Controllers\Questions;

use App\Factories\ModelWithTextFactory;
use App\Http\Controllers\Controller;
use App\Http\Requests\InstanceWithTextRequest;
use App\Http\Requests\QuestionUpdateOrCreateRequest;
use App\Interfaces\Group\ChainServiceInterface;
use App\Models\Group;
use App\Models\Qoptions;
use App\Models\QPart;
use App\Models\Question;
use App\Services\Group\QuestionService;
use DOMDocument;
use DOMXPath;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class QuestionController extends Controller
{

    public function __construct(public QuestionService $mainService)
    {}

    /**
    * @OA\Get (
    *     path="/questions",
    *     tags={"questions"},
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

    /**
     * @OA\Post(
     *      path="/questions",
     *      tags={"questions"},
     *     @OA\Parameter(
     *           name="text",
     *           @OA\Schema(type="string"),
     *           in="query"
     *         ),
     *      @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="qoptions", type="array",
     *                  @OA\Items(
     *                      @OA\Property(property="text", type="string"),
     *                      @OA\Property(property="correct", type="boolean"),
     *                  ),
     *               ),
     *            )
     *      ),
     *     @OA\Parameter(
     *           name="type",
     *           @OA\Schema(type="integer"),
     *           in="query"
     *         ),
     *     @OA\Parameter(
     *           name="group_id",
     *           @OA\Schema(type="integer"),
     *           in="query"
     *     ),
     *     @OA\Parameter(
     *           name="chain_element_id",
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
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \App\Models\AbstractModelWithText
     * @throws \Exception
     */
    public function store(InstanceWithTextRequest $request)
    {
        return $this->mainService->store($request);
    }

    /**
     * @OA\Get (
     *     path="/questions/{question}",
     *     tags={"questions"},
     *     @OA\Parameter(
     *           name="question",
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
    public function show(Question $question)
    {
        return $this->mainService->show($question);
    }

    /**
     * @OA\Patch  (
     *     path="/questions/{question}",
     *     tags={"questions"},
     *     @OA\Parameter(
     *           name="question",
     *           @OA\Schema(type="integer"),
     *           in="path"
     *         ),
     *     @OA\RequestBody(
     *          @OA\JsonContent(
     *              type="object",
     *              @OA\Property(property="group_id", type="integer"),
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
    public function update(QuestionUpdateOrCreateRequest $request, Question $chain)
    {
        return $this->mainService->update($request, $chain);
    }

    /**
    * @OA\Delete (
    *     path="/questions/{question}",
    *     tags={"questions"},
    *     @OA\Parameter(
    *           name="question",
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
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Question  $question
     * @return bool
     */
    public function destroy(Question $question)
    {
        return $this->mainService->destroy($question);
    }
}
