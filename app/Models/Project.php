<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'projects';

    protected $guarded = false;

    use HasFactory;

    public function workers() {
        //return $this->belongsToMany(Worker::class, 'project_workers', 'project_id', 'worker_id');
        return $this->belongsToMany(Worker::class); // с конвенцией laravel
    }
}
