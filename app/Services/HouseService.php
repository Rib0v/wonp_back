<?php

namespace App\Services;

use App\Http\Resources\HouseResource;
use App\Models\House;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HouseService
{
    /**
     * Использовал бы для кеширования phpredis
     * и фасад Redis, но здесь это усложнит
     * запуск проекта проверяющим
     */
    public function getCachedData()
    {
        if (!Cache::has('houses')) {
            $data = HouseResource::collection(House::all());
            Cache::put('houses', $data);
        }

        return Cache::get('houses');
    }

    public function getFilteredData(Request $request)
    {
        $houses = House::query()
            ->filterName($request)
            ->filterExact($request)
            ->filterRange($request)
            ->get();

        return HouseResource::collection($houses);
    }
}
