<?php

namespace AVDPainel\Repositories\Admin;


use AVDPainel\Models\Admin\ConfigSlider as Model;
use AVDPainel\Interfaces\Admin\ConfigSliderInterface;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Storage;

class ConfigSliderRepository implements ConfigSliderInterface
{
    use ValidatesRequests;

    public $model;

    /**
     * Create construct.
     *
     * @return void
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * ValidatesRequests
     *
     * @param  array $input
     * @param  array $messages
     * @return array
     */
    public function rules($input, $messages, $id='')
    {
        $this->validate($input, $this->model->rules($id), $messages);
    }
    

    public function get($value, $id)
    {
        $data = $this->model->find($id);
        return $data->value;
    }


    public function setId($id)
    {
        return $this->model->find($id);
    }


    public function update($input, $id)
    {
        $width        = $input['width'];
        $height       = $input['height'];
        $width_thumb  = $input['width_thumb'];
        $height_thumb = $input['height_thumb'];
        $path         = 'public/'.$input['path'];

        $path_image = $path .$width.'x'.$height;
        if ( !file_exists($path_image) ) {
            Storage::makeDirectory($path_image, 0777, true);
        }

        $path_thumb = $path.$width_thumb.'x'.$height_thumb;
        if ( !file_exists($path_thumb) ) {
            Storage::makeDirectory($path_thumb, 0777, true);
        }

        $data = $this->model->find($id);

        $update = $data->update($input);
        if ($update) {

            generateAccessesTxt(
                date('H:i:s').utf8_decode(
                ' Alterou a configuração do slider da home:'
                .($data->info == 1 ? 'Ativo' : 'Inativo').
                ', Pasta:'.$data->path)
            );
            return true;
        }

        return false;

    }

}