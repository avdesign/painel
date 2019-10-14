<?php

namespace AVDPainel\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $fillable = [
        'uf',
        'name'
    ];

    public $timestamps = false;
}
