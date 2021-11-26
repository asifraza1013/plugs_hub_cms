<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ChargerBox extends Model
{
    protected $fillable = ['name', 'status', 'type', 'image'];
}
