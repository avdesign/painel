<?php

namespace AVDPainel\Repositories\Admin;


use AVDPainel\Models\Admin\ImageSlider as Model;
use AVDPainel\Interfaces\Admin\ImageSliderInterface;

use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

use Illuminate\Foundation\Validation\ValidatesRequests;

class ImageSliderRepository implements ImageSliderInterface
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
        $this->model   = $model;
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
     * Create
     *
     * @param  int $id module
     * @param  array $input
     * @return boolean true or false
     */
    public function create($input, $id)
    {
        if (strlen($input['order']) == 1) {
            $input['order'] = '0'.$input['order'];
        }

        $conf  = $input['config'];
        $file  = $input['image'];
        $ext   = $file->getClientOriginalExtension();
        $name  = 'banner-'. Str::slug(config('app.name')).'-'.date('Ymdhs').'.'.$ext;
        $path  = $conf['disk'] . $conf['path'].$name;
        $path_thumb = $conf['disk'] . $conf['path_thumb'].$name;

        $thumb  = Image::make($file)->resize($conf['width_thumb'], $conf['height_thumb'])->save($path_thumb);
        $upload = Image::make($file)->resize($conf['width'], $conf['height'])->save($path);

        if ($upload) {

            $input['image'] = $name;
            $data = $this->model->create($input);
            if ($data) { 
         
                generateAccessesTxt(date('H:i:s').utf8_decode(
                    ' Adicionou uma imagem no slider da home')
                );

                ($data->active == constLang('active_true') ? $class = 'button icon-tick green-gradient' : $class = 'button icon-tick red-gradient');

                $route_order  = route($data->type.'-slider.order');
                $route_status = route($data->type.'-slider.status', $data->id);
                $route_delete = route($data->type.'-slider.destroy', ['id' => $id, 'file' => $data->id]);
                $route_edit   = route($data->type.'-slider.edit', ['id' => $id, 'file' => $data->id]);

                $out = array(
                    "success"    => true,
                    "message"    => "A imagem {$input['type']} foi salva.",
                    'ac'         => 'create',
                    "id"         => $data->id,
                    'idm'        => $id,
                    "type"       => $input['type'],
                    "path"       => url($conf['photo_url'].$name),
                    "status"     => $data->active,
                    "order"      => $data->order,
                    "btn"        => $conf['btn'],
                    "class"      => $class,
                    'token'      => csrf_token(),
                    "url_order"  => "updateBannerOrder('{$data->id}', '".$route_order."', '".csrf_token()."')",
                    "url_status" => "statusImage('{$data->id}', '".$route_status."', '".csrf_token()."')",
                    "url_delete" => "deleteImage('{$data->id}', '".$route_delete."', '".csrf_token()."')",
                    "url_edit"   => "abreModal('Editar: {$data->type}', '".$route_edit."', 'form-image', 2, 'true', 500, 400)",
                    "script"     => '<script>$("#order-'.$data->id.'").menuTooltip("Carregando...",{classes:["with-mid-padding"],ajax:"images/'.$data->id.'/slider/order",onShow:function(e){e.parent().removeClass("show-on-parent-hover")},onRemove:function(e){e.parent().addClass("show-on-parent-hover")}});</script>'
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
     * @param  int $id brand
     * @param  int $idfile 
     * @param  array $input
     * @return boolean true or false
     */
    public function update($input, $id, $idfile)
    {
        if (strlen($input['order']) == 1) {
            $input['order'] = '0'.$input['order'];
        }

        $data = $this->model->find($idfile);
        $conf = $input['config'];
        // Remove image current
        $current = $conf['disk'] . $conf['path'] .$data->image;
        if (file_exists($current)) {
            unlink($current);
        }
        $thumb = $conf['disk'] . $conf['path_thumb'] .$data->image;
        if (file_exists($thumb)) {
            unlink($thumb);
        }


        $file = $input['image'];
        $ext  = $file->getClientOriginalExtension();
        $name = $input['type'].'-'.Str::slug(config('app.name'), '-').'-'.date('Ymdhs').'.'.$ext;
        $path = $conf['disk'] . $conf['path'].$name;
        $file->move($conf['disk'] . $conf['path'], $name);
        $status = $data->active;

        $upload = Image::make($path)->resize($conf['width'], $conf['height'])->save();
        if ($upload) {

            $input['image'] = $name;

            $update = $data->update($input);
            if ($update) {
                generateAccessesTxt(
                    date('H:i:s').utf8_decode(
                    " Alterou o ".$input['type'].
                    ', Status:'.$status.
                    ' para Status:'.$data->active)
                );

                ($data->active == constLang('active_true') ? $class = 'button icon-tick green-gradient' : $class = 'button icon-tick red-gradient');

                $route_status = route($data->type.'-slider.status', $data->id);
                $route_order  = route($data->type.'-slider.order');
                $route_delete = route($data->type.'-slider.destroy', ['id' => $id, 'file' => $data->id]);
                $route_edit   = route($data->type.'-slider.edit', ['id' => $id, 'file' => $data->id]);

                $out = array(
                    "success"    => true,
                    "message"    => "A imagem {$input['type']} foi alterada.",
                    'ac'         => 'update',
                    "id"         => $data->id,
                    'idm'        => $id,
                    "type"       => $input['type'],
                    "path"       => url($conf['photo_url'].$name),
                    "status"     => $data->active,
                    "order"      => $data->order,
                    "btn"        => $conf['btn'],
                    "class"      => $class,
                    'token'      => csrf_token(),
                    "url_order"  => "updateBannerOrder('{$data->id}', '".$route_order."', '".csrf_token()."')",
                    "url_status" => "statusImage('{$data->id}', '".$route_status."', '".csrf_token()."')",
                    "url_delete" => "deleteImage('{$data->id}', '".$route_delete."', '".csrf_token()."')",
                    "url_edit"   => "abreModal('Editar: {$data->type}', '".$route_edit."', 'form-image', 2, 'true', 500, 400)",
                    "script"     => '<script>$("#order-'.$data->id.'").menuTooltip("Carregando...",{classes:["with-mid-padding"],ajax:"images/'.$data->id.'/slider/order",onShow:function(e){e.parent().removeClass("show-on-parent-hover")},onRemove:function(e){e.parent().addClass("show-on-parent-hover")}});</script>'
                );

                return $out;
            }
        }

        return array(
            'success' => false,
            'message' => "Não foi possível alterar o {$input['type']}");
    }

    /**
     * Remove
     *
     * @param  int $id
     * @return boolean true or false
     */
    public function delete($id, $conf='')
    {
        $count = count($this->getAll($conf['type']));
        if ($count >= 2) {
            $data   = $this->setId($id);

            $image = $conf['disk'] .$conf['path'] .$data->image;
            $image_thumb = $conf['disk'] .$conf['path_thumb'] .$data->image;

            if (file_exists($image)) {
                unlink($image);
            }

            if (file_exists($image_thumb)) {
                unlink($image_thumb);
            }

            $delete = $data->delete();
            if ($delete) {
                generateAccessesTxt(
                    date('H:i:s').utf8_decode(
                        ' Excluiu a imagem do slider')
                );
                return true;
            }
        } else {
            return array(
                "error" => 'delete_min',
                "count" => $count
            );
        }
        return false;
    }


    /**
     * Alterar Status
     *
     * @param  int $id 
     * @return json
     */
    public function status($id)
    {
        $data = $this->model->find($id);
        ($data->active == constLang('active_true') ?
            $change = ['active' => constLang('active_false')] :
            $change = ['active' => constLang('active_true')]);

        $update = $data->update($change);
        if ($update) {
            generateAccessesTxt(
                date('H:i:s').utf8_decode(
                " Alterou o status da imagen do slider")
            );

            ($data->active == constLang('active_true') ? $class = 'button icon-tick green-gradient' : $class = 'button icon-tick red-gradient');

            $out = array(
                "success"    => true,
                "message"    => "Alterou o status da imagem do slider.",
                "class"      => $class
            );               

            return $out;
        }

        return array(
            'success' => false,
            'message' => "Não foi possível alterar o status.");

    }

    /**
     * Retorna a ordem do banner
     * @param $id
     * @return mixed
     */
    public function getOrder($id)
    {
        $data = $this->setId($id);
        return $data->order;
    }

    /**
     * Alterar ordem do banner
     * @param $input
     * @param $messages
     * @return array
     */
    public function updateOrder($input, $messages)
    {
        $change['order'] = $input['order'];

        if (strlen($input['order']) == 1) {
            $change['order'] = '0'.$input['order'];
        }
        $data = $this->setId($input['id']);

        $update = $data->update($change);
        if ($update) {
            $success = true;
            $message = $messages['success_update'];
            generateAccessesTxt(date('H:i:s').utf8_decode('Alterou a ordem da imagem do slider'));
        } else {
            $success = false;
            $message = $messages['error'];
        }

        $out = array(
            "success" => $success,
            "message" => $message,
        );

        return $out;
    }

    /**
     * Retorna as imagens referente a tipo de sider
     * @param $type
     * @return mixed
     */
    public function getAll($type)
    {
        $data  = $this->model->orderBy('order')->where('type', $type)->get();
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



}