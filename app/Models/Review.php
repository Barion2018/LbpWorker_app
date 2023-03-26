<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $guarded = false;

    use HasFactory;

    public function reviewable() {
        return $this->morphTo();
    }
}
