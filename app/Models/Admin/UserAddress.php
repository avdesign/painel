<?php

namespace AVDPainel\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{

    protected $fillable = [
        'user_id',
        'delivery',
        'invoice',
        'address',
        'number',
        'complement',
        'district',
        'city',
        'state',
        'country',
        'zip_code'
    ];
}
