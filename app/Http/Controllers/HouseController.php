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

        return response(['data' => $houses]);
    }
}
