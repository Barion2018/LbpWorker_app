<?php

namespace App\Http\Filter\Var2\Worker;

use Illuminate\Database\Eloquent\Builder;

class To extends AbstractFilter implements FilterInterface
{
    public function applyFilter(Builder $builder)
    {
        $builder->where('age', '<', request('to'));
    }
}
