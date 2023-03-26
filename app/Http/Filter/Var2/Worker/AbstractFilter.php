<?php

namespace App\Http\Filter\Var2\Worker;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Str;

abstract class AbstractFilter
{
    public function handle(Builder $builder, \Closure $next) {
        if (request($this->getName())) {
            $this->applyFilter($builder);
        }
        return $next($builder);
    }

    public function getName(): string
    {
        return Str::snake(class_basename($this));
    }

    abstract public function applyFilter(Builder $builder);
}
