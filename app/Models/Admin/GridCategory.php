<?php

namespace AVDPainel\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class GridCategory extends Model
{

    protected $fillable = [
        'category_id',
        'type',
        'name',
        'label'
    ];

    /**
     * @return array
     **/
    public function rules($type = '')
    {
        return [
            "type" => "required",
            "name"  => "required",
            "label" => "required"
        ];
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
