<?php

namespace AVDPainel\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class OrderNote extends Model
{
    protected $fillable = [
        'order_id',
        'who',
        'name',
        'description'
    ];

    /**
     * @param string $id
     * @return array
     */
    public function rules($id='')
    {
        return [
            "description" => "required"
        ];
    }
}
