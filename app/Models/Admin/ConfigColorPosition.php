<?php

namespace AVDPainel\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class ConfigColorPosition extends Model
{
    protected $fillable = [
        'default',
        'type',
        'width',
        'height',
        'path'
    ];

    const BASE_PATH = 'app/public/images';
    const DIR_IMAGES = 'products';

    const IMAGES_PATH = self::BASE_PATH . '/' . self::DIR_IMAGES;


    /**
     * Validação
     * @return array
     **/
    public function rules($id = '')
    {

        return [
            "width"   => "required|numeric",
            "height"  => "required|numeric",
            "path"    => "required"
        ];
    }

}
