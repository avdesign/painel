<?php

namespace AVDPainel\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class ImageCategory extends Model
{
    protected $fillable = [
        'category_id',
        'image',
        'type',
        'active'
    ];

    /**
     * @return array
     **/
    public function rules($id = '')
    {
        return [
            "category_id" => "required",
            "image"       => "required|image|mimes:jpeg,gif,png|unique:image_categories,image,{$id},id",
            "type"        => "required",
            "active"      => "required"
        ];
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
