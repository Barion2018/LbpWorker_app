<?php

namespace App\Models\Traits;

use App\Http\Filter\Var1\AbstractFilter;
use App\Http\Filter\Var1\FilterInterface;
use Illuminate\Database\Eloquent\Builder;

trait HasFilter
{
    public function scopeFilter(Builder $builder, FilterInterface $filter) {
        $filter->applyFilter($builder);

        return $builder;
    }
}
