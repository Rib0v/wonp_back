<?php

namespace App\Http\Controllers;

use App\Models\House;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class HouseController extends Controller
{
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
