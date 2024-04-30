<?php

namespace App\Models;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Follower extends Model
{
    use HasFactory;
    protected $table = 'followers';
 
    protected $fillable = ['user_id', 'following_id'];

    // Define relationships
    public function user()
    {
        return $this->belongsTo(User::class);
    }



}
