<?php

namespace AVDPainel\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class ConfigSlider extends Model
{
    protected $fillable = [
        'active',
        'delay',
        'path',
        'width',
        'height',
        'width_thumb',
        'height_thumb',
        'width_modal',
        'height_modal'
    ];

    const BASE_PATH = 'app/public/images';
    const DIR_IMAGES = 'slider';

    const IMAGES_PATH = self::BASE_PATH . '/' . self::DIR_IMAGES;

    /**
     * Validação
     * @return array
     **/
    public function rules()
    {
        return [
            "delay"        => "numeric",
            "path"         => "required",
            "width"  	   => "required|numeric",
            "height" 	   => "required|numeric",
            "width_thumb"  => "required|numeric",
            "height_thumb" => "required|numeric",
            "width_modal"  => "required|numeric",
            "height_modal" => "required|numeric"
        ];
    }

}
