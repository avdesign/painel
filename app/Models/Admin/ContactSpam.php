<?php

namespace AVDPainel\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class ContactSpam extends Model
{
    protected $fillable = [
        'subject_id',
        'user_id',
        'subject',
        'name',
        'email',
        'phone',
        'cell',
        'type',
        'message',
        'return',
        'ip',
        'city',
        'state',
        'zip_code',
        'latitude',
        'longitude',
        'admin',
        'send',
        'client',
        'status',
        'date_return'
    ];

    /**
     * @return array
     **/
    public function rules($id='')
    {
        return [];
    }
}
