<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderHasStatus extends Model
{
    protected $fillable = [
        'user_apps_id',
        'provider_id',
        'status',
        'comment',
    ];

    protected $table = 'order_has_status';
}
