<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Position extends Model
{
    protected $table = 'positions';

    protected $guarded = false;

    use HasFactory;

    public function workers() {
        //return $this->hasMany(Worker::class, 'position_id', 'id');
        return $this->hasMany(Worker::class); // с конвенцией laravel
    }

    public function department() {
        //return $this->belongsTo(Department::class, 'department_id', 'id');
        return $this->belongsTo(Department::class); // с конвенцией laravel
    }

    public function queryWorker() {
        return $this->hasOne(Worker::class)->ofMany('age', 'max');
    }
}
