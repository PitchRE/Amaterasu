<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use App\Events\NewUser;

class User extends Authenticatable
{

    public $incrementing = false;
    protected $primaryKey = 'discord_id';

    use Notifiable;

    protected $dispatchesEvents = [
        "created" => NewUser::class,
    ];


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function Tweet()
    {
        return $this->belongsTo(Tweet::class, 'tweet_id', 'id');
    }

    public function Reputation()
    {
        return $this->hasOne(Reputation::class, 'discord_id', 'discord_id');
    }
}