<?php

namespace AVDPainel\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class ConfigKit extends Model
{
    protected $fillable = [
        'name',
        'order',
        'active'
    ];

    /**
     * Validação
     * @return array
     **/
    public function rules($id = '')
    {
        return [
            "name"    => "required",
            "order"    => "required"
        ];
    }
}
