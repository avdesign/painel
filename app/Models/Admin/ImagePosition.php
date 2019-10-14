<?php

namespace AVDPainel\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class ImagePosition extends Model
{
    protected $fillable = [
        'image_color_id',
        'image',
        'order',
        'active'
    ];

    /**
     * Color
     * @return array
     **/
    public function color()
    {
        return $this->belongsTo(ImageColor::class, 'image_color_id');
    }
}
