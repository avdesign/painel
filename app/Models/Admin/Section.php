<?php

namespace AVDPainel\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    protected $fillable = [
        'name',
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
            "name" => "required|unique:sections,name,{$id},id",
            "order" => "required"
        ];
    }




    /**
     * Grids
     * @return array
     **/
    public function grids()
    {
        return $this->hasMany(GridSection::class);
    }

    /**
     * Images
     * @return array
     **/
    public function images()
    {
        return $this->hasMany(ImageSection::class);
    }

    /**
     * Categories
     * @return array
     **/
    public function categories()
    {
        return $this->hasMany(Category::class);
    }

    /**
     * Products
     * @return array
     **/
    public function products()
    {
        return $this->hasMany(Product::class);
    }

}
