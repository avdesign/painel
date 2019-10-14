<?php

namespace AVDPainel\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class GridBrand extends Model
{
    protected $fillable = [
        'brand_id',
        'type',
        'name',
        'label'
    ];

    /**
     * @param int $id
     * @return array
     */
    public function rules($id = '')
    {
        return [
            "type" => "required",
            "name"  => "required",
            "label" => "required"
        ];
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }


}