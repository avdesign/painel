<?php

namespace AVDPainel\Repositories\Admin;


use AVDPainel\Models\Admin\ImageSection as Model;
use AVDPainel\Interfaces\Admin\SectionInterface as InterModel;
use AVDPainel\Interfaces\Admin\ConfigKeywordInterface as Keywords;
use AVDPainel\Interfaces\Admin\ImageSectionInterface;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

use Illuminate\Foundation\Validation\ValidatesRequests;

class ImageSectionRepository implements ImageSectionInterface
{
    use ValidatesRequests;

    public $model;
    public $interModel;
    public $keywords;

    /**
     * Create construct.
     *
     * @return void
     */
    public function __construct(
        Model $model,
        Keywords $keywords, 
        InterModel $interModel)
    {
        $this->model      = $model;
        $this->keywords   = $keywords;
        $this->interModel = $interModel;
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



    /**
     * Init Model
     *
     * @return array
     */
    public function getAll($id)
    {
        $data  = $this->model->where('section_id', $id)->get();
        return $data;    
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return array
     */
    public function setId($id)
    {
        return $this->model->find($id);
    }

    /**
     * Create
     *
     * @param  int $id module
     * @param  array $input
     * @return boolean true or false
     */
    public function create($input, $id)
    {
        ($input['type'] == 'featured' ? $type = 'destaque' : $type = $input['type']);
        $words = $this->keywords->rand();
        $mode  = $this->interModel->setId($id);
        $conf  = $input['config'];
        $file  = $input['image'];
        $ext   = $file->getClientOriginalExtension();
        $name  = Str::slug($words['description'].'-'.$mode->slug.'-'.config('app.name').'-'.$type).'-'.date('Ymdhs').'.'.$ext;
        $path = $conf['disk'] . $conf['path'].$name;
        $file->move($conf['disk'] . $conf['path'], $name);

        $upload = Image::make($path)->resize($conf['width'], $conf['height'])->save();
        if ($upload) {

            $input['image'] = $name;
            $data = $this->model->create($input);
            if ($data) { 
         
                generateAccessesTxt(date('H:i:s').utf8_decode(
                    ' Adicionou a imagem:'.$type.
                    ', Status:'.$data->active.
                    ', Seção:'.$mode->name)
                );

                ($data->active == constLang('active_true') ? $class = 'button icon-tick green-gradient' : $class = 'button icon-tick red-gradient');

                $route_status = route($data->type.'-section.status', $data->id);
                $route_delete = route($data->type.'-section.destroy', ['id' => $id, 'file' => $data->id]);
                $route_edit   = route($data->type.'-section.edit', ['id' => $id, 'file' => $data->id]);

                $out = array(
                    "success"    => true,
                    "message"    => "A imagem {$type} foi salva.",
                    'ac'         => 'create',
                    "id"         => $data->id,
                    'idm'        => $id,
                    "type"       => $input['type'],
                    "path"       => url($conf['photo_url'].$name),
                    "status"     => $data->active,
                    "btn"        => $conf['btn'],
                    "class"      => $class,
                    'token'      => csrf_token(),
                    "url_status" => "statusImage('{$data->id}', '".$route_status."', '".csrf_token()."')",
                    "url_delete" => "deleteImage('{$data->id}', '".$route_delete."', '".csrf_token()."')",
                    "url_edit"   => "abreModal('Editar: {$type}', '".$route_edit."', 'form-image', 2, 'true', 500, 400)"
                );

                return $out;
            }
        }

        return array(
            'success' => false,
            'message' => "Não foi possível altera o {$input['type']}.");
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int $id section
     * @param  int $idfile 
     * @param  array $input
     * @return boolean true or false
     */
    public function update($input, $id, $idfile)
    {
        ($input['type'] == 'featured' ? $type = 'destaque' : $type = $input['type']);

        $data = $this->model->find($idfile);
        $mode = $this->interModel->setId($id);
        $conf = $input['config'];
        // Remove image current
        $current = $conf['disk'] . $conf['path'] .$data->image;
        if (file_exists($current)) {
            unlink($current);
        }

        $words = $this->keywords->rand();
        $file  = $input['image'];
        $ext   = $file->getClientOriginalExtension();
        $name  = Str::slug($words['description'].'-'.$mode->slug.'-'.config('app.name').'-'.$type).'-'.date('Ymdhs').'.'.$ext;
        $path = $conf['disk'] . $conf['path'].$name;
        $file->move($conf['disk'] . $conf['path'], $name);

        $upload = Image::make($path)->resize($conf['width'], $conf['height'])->save();
        if ($upload) {

            $input['image'] = $name;

            $update = $data->update($input);
            if ($update) {
                generateAccessesTxt(
                    date('H:i:s').utf8_decode(
                        " Alterou a imagem ".$type.
                        ', Status:'.$data->active.
                        ', Seção:'.$mode->slug)
                );

                ($data->active == constLang('active_true') ? $class = 'button icon-tick green-gradient' : $class = 'button icon-tick red-gradient');

                $route_status = route($data->type.'-section.status', $data->id);
                $route_delete = route($data->type.'-section.destroy', ['id' => $id, 'file' => $data->id]);
                $route_edit   = route($data->type.'-section.edit', ['id' => $id, 'file' => $data->id]);

                $out = array(
                    "success"    => true,
                    "message"    => "A imagem {$type} foi alterada.",
                    'ac'         => 'update',
                    "id"         => $data->id,
                    'idm'        => $id,
                    "type"       => $input['type'],
                    "path"       => url($conf['photo_url'].$name),
                    "status"     => $data->active,
                    "btn"        => $conf['btn'],
                    "class"      => $class,
                    'token'      => csrf_token(),
                    "url_status" => "statusImage('{$data->id}', '".$route_status."', '".csrf_token()."')",
                    "url_delete" => "deleteImage('{$data->id}', '".$route_delete."', '".csrf_token()."')",
                    "url_edit"   => "abreModal('Editar: {$data->type}', '".$route_edit."', 'form-image', 2, 'true', 500, 400)"
                );

                return $out;
            }
        }

        return array(
            'success' => false,
            'message' => "Não foi possível alterar o {$type}");
    }

    /**
     * Remove
     *
     * @param  int $id
     * @return boolean true or false
     */
    public function delete($id, $conf='')
    {

        $data   = $this->model->find($id);
        $ship   = $data->section;

        $image = $conf['disk'] .$conf['path'] .$data->image;
        if (file_exists($image)) {
            unlink($image);
        }

        $delete = $data->delete();
        if ($delete) {
            ($data->type == 'featured' ? $type = 'destaque' : $type = $data->type);
            generateAccessesTxt(
                date('H:i:s').utf8_decode(
                ' Excluiu a imagem  '.$type.
                ', da Seção:'.$ship->name)
            );
            return true;
        }
        return false;
    }


    /**
     * Status
     *
     * @param  int $id 
     * @return json
     */
    public function status($id)
    {
        $data = $this->model->find($id);
        $mode = $this->interModel->setId($data->section_id);

        ($data->active == constLang('active_true') ?
            $change = ['active' => constLang('active_false')] :
            $change = ['active' => constLang('active_true')]);
        ($data->type == 'featured' ? $type = 'destaque' : $type = $data->type);

        $update = $data->update($change);
        if ($update) {
            ($data->type == 'featured' ? $type = 'destaque' : $type = $data->type);
            generateAccessesTxt(
                date('H:i:s').utf8_decode(
                " Alterou o status da imagem ".$type.
                ', para '.$data->active.
                ', da seção:'.$mode->name)
            );

            ($data->active == constLang('active_true') ? $class = 'button icon-tick green-gradient' : $class = 'button icon-tick red-gradient');

            $out = array(
                "success"    => true,
                "message"    => "A status do {$type} foi alterado.",
                "class"      => $class
            );               

            return $out;
        }

        return array(
            'success' => false,
            'message' => "Não foi possível alterar o status.");

    }

}