<?php

namespace AVDPainel\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class ConfigSubjectContact extends Model
{
    protected $fillable = [
        'label',
        'message',
        'order',
        'active',
        'send_guest',
        'send_user'
    ];

    /**
     * Validação
     * @return array
     **/
    public function rules($id = '')
    {
        return [
            "label"   => "required",
            "message" => "min:10",
            "order"   => "required"
        ];
    }

}
