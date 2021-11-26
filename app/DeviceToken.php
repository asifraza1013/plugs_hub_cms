<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DeviceToken extends Model
{
    protected $fillable = ['user_apps_id', 'device_token'];
}
