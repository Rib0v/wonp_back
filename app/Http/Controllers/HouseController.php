<?php

namespace App\Http\Controllers;

use App\Models\House;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class HouseController extends Controller
{
    /**
     * Это аннотации для генерации Swagger-спецификации.
     * При желании можно вынести в отдельный файл,
     * но оставил здесь для наглядности.
     * 
     * @OA\Get(
     *   tags={"House"},
     *   path="/api/houses",
     *   summary="INDEX - filtered list of houses",
     *   description="",
     *   @OA\Parameter(name="name", in="query", description="Пример: xav",
     *     @OA\Schema(type="string")
     *   ),
     *   @OA\Parameter(name="minprice", in="query", description="Пример: 300000",
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\Parameter(name="maxprice", in="query", description="Пример: 500000",
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\Parameter(name="bedrooms", in="query", description="Пример: 4",
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\Parameter(name="bathrooms", in="query", description="Пример: 3",
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\Parameter(name="storeys", in="query", description="Пример: 2",
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\Parameter(name="garages", in="query", description="Пример: 2",
     *     @OA\Schema(type="integer")
     *   ),
     *   @OA\Response(
     *     response=200,
     *     description="OK",
     *     @OA\JsonContent(
     *       type="object",
     *       @OA\Property(
     *         property="data",
     *         type="array",
     *         @OA\Items(
     *           @OA\Property(property="id", type="integer", example="1"),
     *           @OA\Property(property="name", type="string", example="The Victoria"),
     *           @OA\Property(property="price", type="integer", example="374662"),
     *           @OA\Property(property="bedrooms", type="integer", example="4"),
     *           @OA\Property(property="bathrooms", type="integer", example="2"),
     *           @OA\Property(property="storeys", type="integer", example="2"),
     *           @OA\Property(property="garages", type="integer", example="2"),
     *         ),
     *       ),
     *     )
     *   )
     * )
     */
    public function index(Request $request): Response
    {
        $houses = House::query()
            ->filterName($request)
            ->filterExact($request)
            ->filterRange($request)
            ->get();

        /**
         * обернул в data, чтобы в условном будущем
         * при добавлении пагинации структура осталась
         * прежней и не пришлось переписывать фронтенд
         */
        return response(['data' => $houses]);
    }
}
