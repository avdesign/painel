<?php

namespace AVDPainel\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class ConfigAdmin extends Model
{
    protected $fillable = [
        'path',
        'width_photo',
        'height_photo'
    ];

    const BASE_PATH = 'app/public/images';
    const DIR_IMAGES = 'admins';

    const IMAGES_PATH = self::BASE_PATH . '/' . self::DIR_IMAGES;


    /**
     * Validação
     * @return array
     **/
    public function rules()
    {
        return [
            "path" => "required",
            "width_photo" => "required|numeric",
            "height_photo" => "required|numeric"
        ];
    }
}
