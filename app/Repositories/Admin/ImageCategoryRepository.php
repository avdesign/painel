<?php

namespace AVDPainel\Repositories\Admin;


use AVDPainel\Models\Admin\ImageCategory as Model;
use AVDPainel\Interfaces\Admin\CategoryInterface as InterModel;
use AVDPainel\Interfaces\Admin\ConfigKeywordInterface as Keywords;
use AVDPainel\Interfaces\Admin\ImageCategoryInterface;
use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

use Illuminate\Foundation\Validation\ValidatesRequests;

class ImageCategoryRepository implements ImageCategoryInterface
{
    use ValidatesRequests;

    public $model;
    public $keywords;
    public $interModel;

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
        $data  = $this->model->where('category_id', $id)->get();
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
                    ', Categoria:'.$mode->slug)
                );

                ($data->active == constLang('active_true') ? $class = 'button icon-tick green-gradient' : $class = 'button icon-tick red-gradient');

                $route_status = route($data->type.'-category.status', $data->id);
                $route_delete = route($data->type.'-category.destroy', ['id' => $id, 'file' => $data->id]);
                $route_edit   = route($data->type.'-category.edit', ['id' => $id, 'file' => $data->id]);

                ($data->type == 'featured' ? $type = 'destaque' : $type = $data->type);

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
            'message' => "Não foi possível altera o {$type}.");
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int $id category
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
                    ', Categoria:'.$mode->slug)
                );

                ($data->active == constLang('active_true') ? $class = 'button icon-tick green-gradient' : $class = 'button icon-tick red-gradient');

                $route_status = route($data->type.'-category.status', $data->id);
                $route_delete = route($data->type.'-category.destroy', ['id' => $id, 'file' => $data->id]);
                $route_edit   = route($data->type.'-category.edit', ['id' => $id, 'file' => $data->id]);

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

        $image = $conf['disk'] .$conf['path'] .$data->image;
        if (file_exists($image)) {
            unlink($image);
        }

        $delete = $data->delete();
        if ($delete) {
            ($data->type == 'featured' ? $type = 'destaque' : $type = $data->type);
            generateAccessesTxt(
                date('H:i:s').utf8_decode(
                ' Excluiu a imagem '.$type.
                ', da categoria:'.$data->slug)
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
        $mode = $this->interModel->setId($data->category_id);

        ($data->active == constLang('active_true') ?
            $change = ['active' => constLang('active_false')] :
            $change = ['active' => constLang('active_true')]);
        ($data->type == 'featured' ? $type = 'destaque' : $type = $data->type);

        $update = $data->update($change);
        if ($update) {
            generateAccessesTxt(
                date('H:i:s').utf8_decode(
                " Alterou o status da imagem ".$type.
                ', para '.$data->active.
                ', da categoria:'.$mode->slug)
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