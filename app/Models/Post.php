<?php

namespace App\Models;

use App\Models\Like;
use App\Models\User;
use App\Models\Report;
use App\Models\Comment;
use Conner\Likeable\Likeable;
use Illuminate\Support\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Post extends Model
{
    use HasFactory, Likeable;


    protected $table = 'posts';
    protected $fillable = ['title', 'body'];
    
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
    //Relation Method=>One to Many



    public function user()
    {
        return $this->belongsTo(User::class);
    }
   
    // public function scopeSort(Builder $builder, array $params)
    // {
    //     if (isset($params['sortBy']) && $params['sortBy'] == 'created_at') {
    //         $builder->orderBy('created_at', 'desc');
    //     }



    //     return $builder;
    // }

    public function reports()
    {
        return $this->hasMany(Report::class);
    }
}
