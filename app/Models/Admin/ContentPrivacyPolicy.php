<?php

namespace AVDPainel\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class ContentPrivacyPolicy extends Model
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


