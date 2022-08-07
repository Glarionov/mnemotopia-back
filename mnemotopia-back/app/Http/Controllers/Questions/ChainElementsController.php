<?php

namespace App\Http\Controllers\Questions;

use App\Factories\ModelWithTextFactory;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChainElementUpdateOrCreateRequest;
use App\Http\Requests\InstanceWithTextRequest;
use App\Interfaces\Group\ChainServiceInterface;
use App\Models\ChainElements;
use App\Models\Chains;
use App\Services\Group\ChainElementService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChainElementsController extends Controller
{

    public function __construct(public ChainElementService $mainService)
    {}

    /**
     * @OA\Get(
     *      path="/chain-elements",
     *      tags={"chain-elements"},
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
     *      path="/chain-elements",
     *      tags={"chain-elements"},
     *      @OA\Parameter(
     *            name="chain_id",
     *            required=false,
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
    public function store(ChainElementUpdateOrCreateRequest $request)
    {
        return $this->mainService->store($request);
    }

    /**
    * @OA\Get (
    *     path="/chain-elements/{chain-element}",
    *     tags={"chain-elements"},
    *     @OA\Parameter(
    *           name="chain-element",
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
    public function show(ChainElements $chainElement)
    {
        return $this->mainService->show($chainElement);
    }

    /**
    * @OA\Patch  (
    *     path="/chain-elements/{chain-element}",
    *     tags={"chain-elements"},
    *     @OA\Parameter(
    *           name="chain-element",
    *           @OA\Schema(type="integer"),
    *           in="path"
    *         ),
    *     @OA\RequestBody(
    *          @OA\JsonContent(
    *              type="object",
    *              @OA\Property(property="chain_id", type="integer"),
    *              @OA\Property(property="order", type="integer"),
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
    public function update(ChainElementUpdateOrCreateRequest $request, ChainElements $chainElement)
    {
        return $this->mainService->update($request, $chainElement);
    }

    /**
     * @OA\Delete (
     *     path="/chain-elements/{chain-element}",
     *     tags={"chain-elements"},
     *     @OA\Parameter(
     *           name="chain-element",
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
    public function destroy(ChainElements $chainElement)
    {
        return $this->mainService->destroy($chainElement);
    }
}
