<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    protected $guarded = false;

    use HasFactory;

    public function workers() {
        return $this->morphedByMany(Worker::class, 'taggable');
    }

    public function clients() {
        return $this->morphedByMany(Client::class, 'taggable');
    }
}
