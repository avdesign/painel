<?php

namespace AVDPainel\Models\Admin;

use Illuminate\Database\Eloquent\Model;


class Category extends Model
{
    protected $fillable = [
        'section_id',
        'name',
        'section',
        'description',
        'slug',
        'tags',
        'visits',
        'order',
        'active',
        'active_featured',
        'active_banner'
    ];

    /**
     * @return array
     **/
    public function rules($id='')
    {
        return [
            "section_id" => "required",
            "name"       => "required",
            "order"      => "required"
        ];
    }




    /**
     * Grids
     * @return array
     **/
    public function grids()
    {
        return $this->hasMany(GridCategory::class);
    }

    /**
     * Images
     * @return array
     **/
    public function images()
    {
        return $this->hasMany(ImageCategory::class);
    }

    /**
     * Products
     * @return array
     **/
    public function products()
    {
        return $this->hasMany(Product::class);
    }


    /**
     * Section
     * @return array
     **/
    public function section()
    {
        return $this->belongsTo(Section::class);
    }

}
