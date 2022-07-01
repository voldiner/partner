<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Administrator extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',

    ];

    public function shortName()
    {
        $separator = explode(' ', $this->name);
        $counter = count($separator);
        $result = '';
        for ($i = 0; $i < $counter; $i++) {
            $result .= $i === 0 ? $separator[$i] : ' ' . mb_substr($separator[$i], 0, 1) . '.';
        }
        return $result;
    }
}
