<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Casts\Attribute;

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
        'name',
        'email',
        'password',
        'image',
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
            'last_seen' => 'datetime',
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    protected function image(): Attribute
    {
        return Attribute::make(
            get: fn(?string $value) =>
            $value ? asset('images/users/' . $value) : null
        );
    }

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn(?string $value) =>
            $value ? ucfirst($value) : null,

            set: fn(?string $value) =>
            $value ? strtolower($value) : null
        );
    }

    public function conversation_participants()
    {
        return $this->belongsToMany(Conversation::class, 'conversation_participants');
    }

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

        public function lastMessage()
    {
        return $this->hasOne(Message::class)->latestOfMany();
    }

}
