<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
    use HasFactory;
protected $table = 'reports';
protected $hidden = ['post_id'];
protected $fillable = ['post_id','user_id'];

public function post()
{
    return $this->belongsTo(Post::class);
}


}
