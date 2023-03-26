<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProjectWorker extends Model
{
    protected $table = 'project_worker';

    protected $guarded = false;

    use HasFactory;
}
