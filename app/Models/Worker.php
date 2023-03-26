<?php

namespace App\Models;

use App\Events\Worker\CreatedEvent;
use App\Http\Filter\Var1\AbstractFilter;
use App\Models\Traits\HasFilter;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Profile;
use Illuminate\Database\Eloquent\SoftDeletes;


class Worker extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasFilter;

    protected $table = 'workers';

    protected $guarded = false;

    protected static function booted()
    {
        static::created(function ($model) {
            event(new CreatedEvent($model));

//            Profile::create([
//                'worker_id' => $model->id
//            ]);
        });

        static::updated(function ($model) {
            //dd($model);
        });
    }

    public function profile() {
        //return $this->hasOne(Profile::class, 'worker_id', 'id');
        return $this->hasOne(Profile::class); // с конвенцией laravel
    }

    public function position() {
        //return $this->belongsTo(Position::class, 'position_id', 'id');
        return $this->belongsTo(Position::class); // с конвенцией laravel
    }

    public function projects() {
        //return $this->belongsToMany(Project::class, 'project_workers', 'worker_id', 'project_id');
        return $this->belongsToMany(Project::class); // с конвенцией laravel
    }

    public function avatar()
    {
        return $this->morphOne(Avatar::class, 'avatarable');
    }

    public function reviews()
    {
        return $this->morphMany(Review::class, 'reviewable');
    }

    public function tags()
    {
        return $this->morphToMany(Tag::class, 'taggable');
    }
}
