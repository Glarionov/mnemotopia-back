<?php

namespace App\Http\Controllers\Questions;

use App\Factories\ModelWithTextFactory;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChainUpdateOrCreateRequest;
use App\Http\Requests\InstanceWithTextRequest;
use App\Interfaces\Group\ChainServiceInterface;
use App\Models\ChainElements;
use App\Models\Chains;
use App\Models\Question;
use App\Services\Group\ChainService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChainsController extends Controller
{

    public function __construct(public ChainService $mainService)
    {}

    /**
     * @OA\Get(
     *      path="/chains",
     *      tags={"chains"},
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
     *      path="/chains",
     *      tags={"chains"},
     *      @OA\Parameter(
     *            name="text",
     *            @OA\Schema(type="string"),
     *            in="query"
     *          ),
     *      @OA\Parameter(
     *            name="group_id",
     *            @OA\Schema(type="integer"),
     *            in="query"
     *          ),
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
     * @return \Illuminate\Http\Response
     */
    public function store(InstanceWithTextRequest $request)
    {
        return $this->mainService->store($request);
    }

    /**
     * @OA\Get (
     *     path="/chains/{chain}",
     *     tags={"chains"},
     *     @OA\Parameter(
     *           name="chain",
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
    public function show(Chains $chain)
    {
        return $this->mainService->show($chain);
    }

    /**
     * @OA\Patch  (
     *     path="/chains/{chain}",
     *     tags={"chains"},
     *     @OA\Parameter(
     *           name="chain",
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
    public function update(ChainUpdateOrCreateRequest $request, Chains $chain)
    {
        return $this->mainService->update($request, $chain);
    }

    /**
     * @OA\Delete (
     *     path="/chains/{chain}",
     *     tags={"chains"},
     *     @OA\Parameter(
     *           name="chain",
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
    public function destroy(Chains $chain)
    {
        return $this->mainService->destroy($chain);
    }
}
