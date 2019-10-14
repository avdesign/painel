<?php

namespace AVDPainel\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class AdminAccess extends Model
{
    protected $fillable = [
        'admin_id',
        'last_ip',
        'last_url',
        'last_logout',
        'qty_visits'
    ];

    const BASE_PATH = 'app';
    const DIR_FILES = 'Accesses';

    const FILES_PATH = self::BASE_PATH . '/' . self::DIR_FILES;

}
