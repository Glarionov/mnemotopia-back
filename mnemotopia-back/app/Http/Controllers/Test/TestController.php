<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;

class TestController extends Controller
{
    /**
     * @OA\Post(
     *      path="/files",
     *      tags={"File"},
     *      security={
     *          {"passport": {}},
     *      },
     *      @OA\RequestBody(
     *        @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  type="object",
     *                  @OA\Property(
     *                      property="file",
     *                      type="file",
     *                  ),
     *              ),
     *          )
     *      ),
     *     @OA\RequestBody(
     *        @OA\MediaType(
     *              mediaType="multipart/form-data",
     *              @OA\Schema(
     *                  type="object",
     *                  @OA\Property(
     *                      property="file",
     *                      type="file",
     *                  ),
     *              ),
     *          )
     *      ),
     *      @OA\Response(
     *          response=401,
     *          description="Unauthenticated",
     *          @OA\JsonContent(
     *              type="object",
     *          ),
     *      ),
     * )
     *
     */
    public function test()
    {
        return 2;
    }
}
