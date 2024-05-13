<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    public function scopeFilterName(Builder $query, $request)
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
}
