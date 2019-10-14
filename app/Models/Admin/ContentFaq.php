<?php

namespace AVDPainel\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class ContentFaq extends Model
{
    protected $fillable = [
        'question',
        'response',
        'order',
        'active'
    ];

    public function rules()
    {
        return [
            "question" => "required",
            "response" => "required",
            "order" => "required|numeric",
            "active" => "required"
        ];
    }
}
