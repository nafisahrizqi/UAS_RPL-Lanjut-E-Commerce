<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Customer extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function deposits()
    {
        return $this->hasMany(Deposit::class);
    }

    public function loans()
    {
        return $this->hasMany(Loan::class);
    }

    public function collaterals()
    {
        return $this->hasMany(Collateral::class);
    }

    public function foreclosures()
    {
        return $this->hasMany(Foreclosure::class);
    }

    public function visits()
    {
        return $this->hasMany(Visit::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
