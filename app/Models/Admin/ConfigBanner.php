<?php

namespace AVDPainel\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class ConfigBanner extends Model
{
    protected $fillable = [
        'type',
        'active',
        'path',
        'width',
        'height',
    ];

    const BASE_PATH = 'app/public/images';
    const DIR_IMAGES = 'banners';

    const IMAGES_PATH = self::BASE_PATH . '/' . self::DIR_IMAGES;

    /**
     * Validação
     * @return array
     **/
    public function rules()
    {
        return [
            "type"         => "required",
            "path"         => "required",
            "width"  	   => "required|numeric",
            "height" 	   => "required|numeric",
        ];
    }
}
