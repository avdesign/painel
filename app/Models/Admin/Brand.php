<?php

namespace AVDPainel\Models\Admin;

use Illuminate\Database\Eloquent\Model;


class Brand extends Model
{
    protected $fillable = [
        'name',
        'contact',
        'email',
        'phone',
        'address',
        'number',
        'district',
        'city',
        'state',
        'zip_code',
        'description',
        'slug',
        'tags',
        'visits',
        'order',
        'active',
        'active_logo',
        'active_banner'
    ];

    /**
     * @return array
     **/
    public function rules($id = '')
    {
        return [
            "name" => "required|unique:brands,name,{$id},id",
            "order" => "required"
        ];
    }

    /**
     * Email em minúsculo
     *
     * @param  string $value
     * @return void
     */
    public function setEmailAttribute($value)
    {
        $this->attributes['email'] = strtolower($value);
    }


    /**
     * Grids
     * @return array
     **/
    public function grids()
    {
        return $this->hasMany(GridBrand::class);
    }

    /**
     * Images
     * @return array
     **/
    public function images()
    {
        return $this->hasMany(ImageBrand::class);
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