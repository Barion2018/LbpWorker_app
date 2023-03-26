<?php

namespace App\Http\Filter\Var1;

use Illuminate\Database\Eloquent\Builder;

interface FilterInterface
{
    public function applyFilter(Builder $builder);
}
