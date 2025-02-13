<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name','phone',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
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

    public function roles(){
        return $this->hasOne(Roles::class, 'user_id');
    }

    public function flat(){
        return $this->hasOne(Flat::class,'user_id');
    }

    public function ProfilePicture(){
        return $this->hasOne(Document::class,'model_id')->where('model_type','App\Models\User')->where('uuid','profile_picture')->first();    
    }

    public function documents(){
        return $this->hasOne(Document::class,'model_id')->where('model_type','App\Models\User')->where('uuid','documents')->get();   
    }
}
