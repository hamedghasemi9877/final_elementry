<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Models\Post;
use App\Models\Report;
use App\Models\Retweet;
use App\Models\Follower;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    //relation post
    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    //relation like
    public function likes()
    {
        return $this->hasMany(Post::class);
    }

    //relation comment
    public function comments()
    {
        return $this->hasMany(comment::class);
    }

    //relation retweet
    public function retweets()
    {
        return $this->hasMany(Retweet::class);
    }
  

    //relation  follow
    public function followers()
    {
        return $this->hasMany(Follower::class, 'user_id');
    }
    public function following()
    {
        return $this->hasMany(Follower::class, 'following_id');
    }


    public function isFollowing($user_id)
    {
        return $this->following()->where('following_id', $user_id)->exists();
    }

 
}
