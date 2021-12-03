<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ServiceProvider extends Model
{
    protected $casts = [
        'lat' => 'float',
        'lng' => 'float',
    ];

    protected $fillable = [
        'user_apps_id',
        'vendor_id',
        'country',
        'city',
        'address',
        'street',
        'post_code',
        'lat',
        'lng',
        'id_type',
        'id_img_1',
        'id_img_2',
        'bill_img',
        'parking_img',
    ];

    public function user()
    {
        return $this->hasOne('App\UserAPP', 'id', 'user_apps_id');
    }
    public function chargerInfo()
    {
        return $this->hasMany('App\ChargerInfo', 'user_apps_id', 'user_apps_id');
    }
}
