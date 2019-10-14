<?php

namespace AVDPainel\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class ConfigKeyword extends Model
{
    protected $fillable = [
        'title',
        'genders',
        'categories',
        'description',
        'keywords',
        'active'
    ];


    /**
     * Validação
     * @return array
     **/
    public function rules($id = '')
    {
        return [
            "title"       => "required|unique:config_keywords,title,{$id},id",
            "genders"     => "required",
            "categories"  => "required",
            "description" => "required",
            "keywords"     => "required"
        ];
    }
}
