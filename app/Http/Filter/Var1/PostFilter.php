<?php

namespace App\Http\Filter\Var1;

use Illuminate\Database\Eloquent\Builder;

class PostFilter
{
    private array $params = [];

    const TITLE = 'title';
    const VIEW = 'view';


    /**
     * @param array $param
     */
    public function __construct(array $params)
    {
        $this->params = $params;
    }

    public function getCallbacks(): array
    {
        return [
            self::TITLE => 'title',
            self::VIEW => 'view',
        ];
    }

    public function applyFilter($builder)
    {
        //dd('dsvf');

        foreach ($this->getCallbacks() as $key => $callback) {
            if (isset($this->params[$key])) {
                $this->$callback($builder, $this->params[$key]);
            }
        }
    }

    public function title(Builder $builder, $value) {
        $builder->where('name', 'like', "%{$value}%");
    }

    public function view(Builder $builder, $value) {
        $builder->where('surname', 'like', "%{$value}%");
    }
}
