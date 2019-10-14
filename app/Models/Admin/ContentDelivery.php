<?php

namespace AVDPainel\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class ContentDelivery extends Model
{
    protected $fillable = [
        'type',
        'title',
        'description',
        'order',
        'active'
    ];

    public function rules()
    {
        return [
            "type" => "required",
            "title" => "required",
            //"description" => "required",
            "order" => "required|numeric",
            "active" => "required"
        ];
    }
}
