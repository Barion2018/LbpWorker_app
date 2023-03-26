<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
    protected $table = 'departments';

    protected $guarded = false;

    use HasFactory;

    public function boss() {
        //return $this->hasOneThrough(Worker::class, Position::class, 'department_id', 'position_id', 'id', 'id')->where('position_id', 4);
        return $this->hasOneThrough(Worker::class, Position::class)->where('position_id', 4); // с конвенцией laravel
    }

    public function workers() {
        //return $this->hasManyThrough(Worker::class, Position::class, 'department_id', 'position_id', 'id', 'id');
        return $this->hasManyThrough(Worker::class, Position::class); // с конвенцией laravel
    }
}
