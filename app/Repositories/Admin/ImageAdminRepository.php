<?php

namespace AVDPainel\Repositories\Admin;


use AVDPainel\Models\Admin\ImageAdmin as Model;
use AVDPainel\Interfaces\Admin\AdminInterface as InterAdmin;
use AVDPainel\Interfaces\Admin\ImageAdminInterface;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

use Illuminate\Foundation\Validation\ValidatesRequests;

class ImageAdminRepository implements ImageAdminInterface
{


    use ValidatesRequests;



    public $model;
    public $interAdmin;

    /**
     * Create construct.
     *
     * @return void
     */
    public function __construct(Model $model, InterAdmin $interAdmin)
    {
        $this->model      = $model;
        $this->interAdmin = $interAdmin;
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
        $data  = $this->model->where('admin_id', $id)->get();
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
        // id = 86153534

        $admin = $this->interAdmin->setId(numLetter($id));
        $count = count($this->model->where('admin_id', $input['admin_id'])->get());
        if ($count >= 1) {
            return array(
                'success' => false,
                'message' => "Já exite uma foto deste usuário.");
        }




        $conf = $input['config'];
        $file = $input['image'];
        $ext  = $file->getClientOriginalExtension();
        $name = Str::slug($admin->name).'-'.time().'.'.$ext;
        $path = $conf['disk'] . $conf['path'].$name;
        $file->move($conf['disk'] . $conf['path'], $name);

        $upload = Image::make($path)->resize($conf['width'], $conf['height'])->save();
        if ($upload) {

            $input['image'] = $name;
            $data = $this->model->create($input);
            if ($data) { 
         
                generateAccessesTxt(date('H:i:s').utf8_decode(
                    ' Adicionou a foto do usuário:'. $admin->name)
                );

                ($data->active == constLang('active_true') ? $class = 'button icon-tick green-gradient' : $class = 'button icon-tick red-gradient');

                $route_status = route('photo-admin.status', $data->id);
                $route_delete = route('photo-admin.destroy', ['id' => $id, 'file' => $data->id]);
                $route_edit   = route('photo-admin.edit', ['id' => $id, 'file' => $data->id]);

                // Se é o usúario autenticaddo
                (Auth::id() == numLetter($id) ? $auth = true : $auth = false);

                $out = array(
                    "success"    => true,
                    "message"    => "A foto foi salva.",
                    'ac'         => 'create',
                    'auth'       => $auth,
                    "id"         => $data->id,
                    'idm'        => $id,
                    "path"       => url($conf['photo_url'].$name),
                    "status"     => $data->active,
                    "btn"        => $conf['btn'],
                    "class"      => $class,
                    'token'      => csrf_token(),
                    "url_status" => "statusImage('{$data->id}', '".$route_status."', '".csrf_token()."')",
                    "url_delete" => "deleteImage('{$data->id}', '".$route_delete."', '".csrf_token()."')",
                    "url_edit"   => "abreModal('Editar: Foto', '".$route_edit."', 'form-image', 2, 'true', 500, 400)"
                );



                return $out;
            }
        }

        return array(
            'success' => false,
            'message' => "Não foi possível altera a foto.");

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int $id brand
     * @param  int $idfile 
     * @param  array $input
     * @return boolean true or false
     */
    public function update($input, $id, $idfile)
    {
        $data = $this->model->find($idfile);
        $admin = $this->interAdmin->setId(numLetter($id));
        $conf = $input['config'];
        // Remove image current
        $current = $conf['disk'] . $conf['path'] .$data->image;
        if (file_exists($current)) {
            unlink($current);
        }

        $file = $input['image'];
        $ext  = $file->getClientOriginalExtension();
        $name = Str::slug($admin->name).'-'.time().'.'.$ext;
        $path = $conf['disk'] . $conf['path'].$name;
        $file->move($conf['disk'] . $conf['path'], $name);
        $status = $data->status;
        $upload = Image::make($path)->resize($conf['width'], $conf['height'])->save();

        if ($upload) {

            $input['image'] = $name;

            $update = $data->update($input);
            if ($update) {
                generateAccessesTxt(
                    date('H:i:s').utf8_decode(
                    " Alterou a foto do usuário ". $admin->name.
                    ', Status:'.$status)
                );

                ($data->active == constLang('active_true') ? $class = 'button icon-tick green-gradient' : $class = 'button icon-tick red-gradient');
                $route_status = route('photo-admin.status', $data->id);
                $route_delete = route('photo-admin.destroy', ['id' => $id, 'file' => $data->id]);
                $route_edit = route('photo-admin.edit', ['id' => $id, 'file' => $data->id]);

                // Se é o usúario autenticaddo
                (Auth::id() == numLetter($id) ? $auth = true : $auth = false);

                $out = array(
                    "success"    => true,
                    "message"    => "A foto foi alterada.",
                    'ac'         => 'update',
                    'auth'       => $auth,
                    "id"         => $data->id,
                    'idm'        => $id,
                    "path"       => url($conf['photo_url'].$name),
                    "active"     => $data->active,
                    "btn"        => $conf['btn'],
                    "class"      => $class,
                    'token'      => csrf_token(),
                    "url_status" => "statusImage('{$data->id}', '" . $route_status . "', '" . csrf_token() . "')",
                    "url_delete" => "deleteImage('{$data->id}', '" . $route_delete . "', '" . csrf_token() . "')",
                    "url_edit" => "abreModal('Editar: Foto', '" . $route_edit . "', 'form-image', 2, 'true', 500, 400)"
                );

                return $out;
            }
        }

        return array(
            'success' => false,
            'message' => "Não foi possível alterar a foto");
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
        $admin  =
        $admin  = $data->admin;

        $image = $conf['disk'] .$conf['path'] .$data->image;
        if (file_exists($image)) {
            unlink($image);
        }

        $delete = $data->delete();
        if ($delete) {
            generateAccessesTxt(
                date('H:i:s').utf8_decode(
                ' Excluiu a foto do usuário: '.$admin->name)
            );
            return true;
        }
        return false;
    }

    public function deleteExcluded($id, $admin, $conf='')
    {
        $data   = $this->model->find($id);
        $admin  = $this->interAdmin->setIdExcluded(numLetter($admin));

        $image = $conf['disk'] .$conf['path'] .$data->image;
        if (file_exists($image)) {
            unlink($image);
        }

        $delete = $data->delete();
        if ($delete) {
            generateAccessesTxt(
                date('H:i:s').utf8_decode(
                ' Excluiu a foto do usuário: '.$admin->name)
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
        $data = $this->setId($id);
        $admin = $this->interAdmin->setId($data->admin_id);

        ($data->active == constLang('active_true') ?
            $data->active = constLang('active_false') :
            $data->active = constLang('active_true'));

        $update = $data->save();
        if ($update) {
            generateAccessesTxt(
                date('H:i:s').utf8_decode(
                " Alterou o status da foto do usuário ". $admin->name.
                ', para '.$data->active)
            );

            ($data->active == constLang('active_true') ? $class = 'button icon-tick green-gradient' : $class = 'button icon-tick red-gradient');

            $out = array(
                "success"    => true,
                "message"    => "A status da foto foi alterado.",
                "class"      => $class
            );               

            return $out;
        }

        return array(
            'success' => false,
            'message' => "Não foi possível alterar o status.");

    }

}