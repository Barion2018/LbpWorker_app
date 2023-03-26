<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Worker;

class Profile extends Model
{
    protected $table = 'profiles';

    protected $guarded = false;

    use HasFactory;

    public function worker() {
        //return $this->belongsTo(Worker::class, 'worker_id', 'id');
        return $this->belongsTo(Worker::class); // с конвенцией laravel
    }
}
