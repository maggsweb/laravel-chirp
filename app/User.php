<?php

namespace App;

use http\Env\Url;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = [
        'avatar'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // This allows username to be used in the URL
    public function getRouteKeyName()
    {
        return 'username';
    }

    public function posts() {
        return $this->hasMany(Post::class);
    }

    public function following() {
        return $this->belongsToMany('App\User', 'follows', 'user_id', 'follower_id');
    }

    public function followers() {
        return $this->belongsToMany('App\User', 'follows', 'follower_id', 'user_id');
    }

    // Is the user 'yourself' ?
    public function isNotTheUser(User $user) {
        return $this->id !== $user->id;
    }

    // See if the current user is already following a user
    public function isFollowing(User $user)
    {
        return (bool) $this->following->where('id', $user->id)->count();
    }

    // Ensure that you cannot follow yourself, and that your are not already following the user
    public function canFollow(User $user)
    {
        if (!$this->isNotTheUser($user)) {
            return false;
        }
        return !$this->isFollowing($user);
    }

    public function canUnFollow(User $user)
    {
        return $this->isFollowing($user);
    }

    public function getAvatar()
    {
        return 'https://gravatar.com/avatar/'.md5($this->email) . '/?s=45&d=mm';
    }

    public function getAvatarAttribute()
    {
        return $this->getAvatar();
    }

}
