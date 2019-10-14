<?php

namespace AVDPainel\Repositories\Admin;


use AVDPainel\Models\Admin\ConfigAdmin as Model;
use AVDPainel\Interfaces\Admin\ConfigAdminInterface;

use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Storage;

class ConfigAdminRepository implements ConfigAdminInterface
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

        $path = 'public/'.$input['path'];
        $path_photo = $path.$input['width_photo'].'x'.$input['height_photo'];
        if ( !file_exists($path_photo) ) {
            Storage::makeDirectory($path_photo, 0777, true);
        }

        $data = $this->model->find($id);

        $update = $data->update($input);
        if ($update) {

            generateAccessesTxt(
                date('H:i:s').utf8_decode(
                ' Alterou a configuração dos usuários: Pasta:'.$data->path.
                ', Largura:'.$data->width_photo.
                ', Altura:'.$data->height_photo)
            );
            return true;
        }

        return false;

    }

}