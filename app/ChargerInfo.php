<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChargerInfo extends Model
{
    protected $fillable = [
        'user_apps_id',
        'charger_box',
        'charger_plug_type',
        'charger_level',
        'charger_voltage',
        'charger_img',
    ];

    public function detail()
    {
        return $this->belongsTo('App\ChargerBox', 'charger_plug_type', 'id');
    }
}
