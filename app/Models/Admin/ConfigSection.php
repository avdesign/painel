<?php

namespace AVDPainel\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class ConfigSection extends Model
{
    protected $fillable = [
        'grids',
        'description',
        'img_default',
        'path',
        'img_featured',
        'width_featured',
        'height_featured',
        'img_banner',
        'width_banner',
        'height_banner',
        'width_modal',
        'height_modal'
    ];

    const BASE_PATH = 'app/public/images';
    const DIR_IMAGES = 'sections';

    const IMAGES_PATH = self::BASE_PATH . '/' . self::DIR_IMAGES;

    /**
     * Validação
     * @return array
     **/
    public function rules()
    {
        return [
            "path"            => "required",
            "width_featured"  => "required|numeric",
            "height_featured" => "required|numeric",
            "width_banner"    => "required|numeric",
            "height_banner"   => "required|numeric"
        ];
    }
}
