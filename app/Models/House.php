<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class House extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'bedrooms',
        'bathrooms',
        'storeys',
        'garages',
    ];

    public function scopeFilterName(Builder $query, Request $request)
    {
        if ($request->has("name")) {

            /**
             * Нужно для совместимости с разными БД:
             * в PostgreSQL для регистронезависимого
             * поиска используется оператор ILIKE,
             * в MySQL и SQLite - LIKE
             */
            $caseInsensitiveOperator = config('database.default') === 'pgsql' ? 'ILIKE' : 'LIKE';

            $query->where('name', $caseInsensitiveOperator, "%{$request->query("name")}%");
        }
    }

    public function scopeFilterExact(Builder $query, Request $request)
    {
        /**
         * На проде я бы вынес параметры в БД,
         * чтобы можно было их редактировать
         * из админ-панели. И закешировал бы.
         */
        $params = ['bedrooms', 'bathrooms', 'storeys', 'garages'];

        foreach ($params as $param) {
            if ($request->has("$param")) {
                $query->where($param, $request->query("$param"));
            }
        }
    }

    public function scopeFilterRange(Builder $query, Request $request)
    {
        if ($request->has("minprice")) {
            $query->where('price', '>=', $request->query("minprice"));
        }
        if ($request->has("maxprice")) {
            $query->where('price', '<=', $request->query("maxprice"));
        }
    }
}
