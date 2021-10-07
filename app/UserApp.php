<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class UserApp extends Authenticatable
{
    use Notifiable, HasApiTokens;

    protected $guarded=['id'];

    protected $fillable = [
        'google_id',
        'apple_id',
        'image',
        'otp',
        'admin_approved',
        'enable_notifications',
        'app_role',
        'car_brand',
        'car_modal',
        'status',
        'first_name',
        'last_name',
        'email',
        'password',
        'phone',
        'status',
    ];

    public function getAuthPassword()
    {
        return $this->password;
    }
}
