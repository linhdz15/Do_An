<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Arr;

/**
 * @method static \Illuminate\Database\Eloquent\Builder whereLike($column, $keyword)
 */
class BaseModel extends Model
{
    public static function tableName(): string
    {
        return (new static)->getTable();
    }

    protected function escapeLike(?string $string, $expPercent = false): string
    {
        if ($expPercent) {
            $search = ['\\', '_', '&', '|'];
            $replace = ['\\\\', '\_', '\&', '\|'];
        } else {
            $search = ['\\', '%', '_', '&', '|'];
            $replace = ['\\\\', '\%', '\_', '\&', '\|'];
        }

        return str_replace($search, $replace, $string);
    }

    public function scopeWhereLike(Builder $query, string $column, ?string $keyword): Builder
    {
        return $query->where($column, 'like', '%' . $this->escapeLike($keyword) . '%');
    }

    public function scopeOrWhereLike(Builder $query, string $column, ?string $keyword): Builder
    {
        return $query->orWhere->whereLike($column, $keyword);
    }

    public function scopeSearchLike(Builder $query, $attributes = [], ?string $keyword): Builder
    {
        return $this->addSearchConditions($query, $attributes, $keyword);
    }

    protected function addSearchConditions(Builder $query, $attributes = [], ?string $term)
    {
        $searchTerms = explode(' ', $term);

        return $query->where(function (Builder $query) use ($attributes, $searchTerms) {
            foreach (Arr::wrap($attributes) as $attribute) {
                foreach ($searchTerms as $searchTerm) {
                    $sql = "LOWER({$attribute}) LIKE ?";
                    $searchTerm = mb_strtolower($searchTerm, 'UTF8');

                    $query->orWhereRaw($sql, ["%{$searchTerm}%"]);
                }
            }
        });
    }
}
