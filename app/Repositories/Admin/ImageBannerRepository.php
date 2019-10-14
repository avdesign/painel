<?php

namespace AVDPainel\Repositories\Admin;


use AVDPainel\Models\Admin\ImageBanner as Model;
use AVDPainel\Interfaces\Admin\ImageBannerInterface;

use Illuminate\Support\Str;
use Intervention\Image\Facades\Image;

use Illuminate\Foundation\Validation\ValidatesRequests;

class ImageBannerRepository implements ImageBannerInterface
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
     * Salvar as fotos em suas respectivas pastas $input['config']
     *
     * @param $input
     * @param $type
     * @param $message
     * @return array
     */
    public function create($input, $type, $message)
    {
        if (strlen($input['order']) == 1) {
            $input['order'] = '0'.$input['order'];
        }

        $conf  = $input['config'];
        $file  = $input['image'];
        $ext   = $file->getClientOriginalExtension();
        $name  = 'banner-'. Str::slug(config('app.name')).'-'.date('Ymdhs').'.'.$ext;
        $path  = $conf['disk'] . $conf['path'].$name;

        $upload = Image::make($file)->resize($conf['width'], $conf['height'])->save($path);

        if ($upload) {

            $input['image'] = $name;
            $data = $this->model->create($input);
            if ($data) {
                generateAccessesTxt(date('H:i:s').utf8_decode(
                    ' Adicionou um banner')
                );

                ($data->active == constLang('active_true') ? $class = 'button icon-tick green-gradient' : $class = 'button icon-tick red-gradient');

                $route_order  = route('banner.order', $data->type);
                $route_status = route('banner.status', $data->id);
                $route_delete = route('banner.destroy', ['type' => $data->type, 'id' => $data->id]);
                $route_edit   = route('banner.edit', ['type' => $data->type, 'id' => $data->id]);

                $out = array(
                    "success"    => true,
                    "message"    => $message['photo_create_true'],
                    'ac'         => 'create',
                    "id"         => $data->id,
                    'idm'        => $type,
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
                    "script"     => '<script>$("#order-'.$data->id.'").menuTooltip("Carregando...",{classes:["with-mid-padding"],ajax:"images/banner/order/'.$data->id.'",onShow:function(e){e.parent().removeClass("show-on-parent-hover")},onRemove:function(e){e.parent().addClass("show-on-parent-hover")}});</script>'
                );

            } else {
                $out = array(
                    'success' => false,
                    'message' => $message['photo_create_false']
                );
            }
        }

        return $out;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int $id brand
     * @param  int $idfile 
     * @param  array $input
     * @return boolean true or false
     */
    public function update($input, $id, $message)
    {
        if (strlen($input['order']) == 1) {
            $input['order'] = '0'.$input['order'];
        }

        $data = $this->model->find($id);
        $conf = $input['config'];
        // Remove image current
        $current = $conf['disk'] . $conf['path'] .$data->image;
        if (file_exists($current)) {
            unlink($current);
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

                $route_order  = route('banner.order', $data->type);
                $route_status = route('banner.status', $data->id);
                $route_delete = route('banner.destroy', ['type' => $data->type, 'id' => $data->id]);
                $route_edit   = route('banner.edit', ['type' => $data->type, 'id' => $data->id]);


                $out = array(
                    "success"    => true,
                    "message"    => $message['photo_upload_true'],
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
                    "script"     => '<script>$("#order-'.$data->id.'").menuTooltip("Carregando...",{classes:["with-mid-padding"],ajax:"images/banner/order/'.$data->id.'",onShow:function(e){e.parent().removeClass("show-on-parent-hover")},onRemove:function(e){e.parent().addClass("show-on-parent-hover")}});</script>'
                );
            } else {
                $out = array(
                    'success' => false,
                    'message' => $message['photo_upload_false']
                );
            }
        }

        return $out;
    }

    /**
     * Remove apenas se for mmaio que 4 imagens
     *
     * @param $id
     * @param $type
     * @param $message
     * @param $config
     * @return array
     */
    public function delete($id, $type, $message, $config)
    {
        $count = count($this->getAll($type));
        if ($count == 4) {

            $success = false;
            $message = "{$message['photo_delete_min']} {$count}";

        } else {

            $data   = $this->setId($id);
            $image = $config['disk'] .$config['path'] .$data->image;
            if (file_exists($image)) {
                unlink($image);
            }

            $delete = $data->delete();
            if ($delete) {
                generateAccessesTxt(
                    date('H:i:s').utf8_decode(' Excluiu o banner da home')
                );
                $success = true;
                $message = $message['photo_delete_true'];
            } else {
                $success = false;
                $message = $message['photo_delete_false'];
            }
        }

        $out = array(
            "success" => $success,
            "message" => $message
        );

        return $out;
    }


    /**
     * Alterar Status
     *
     * @param  int $id 
     * @return json
     */
    public function status($id, $message)
    {
        $data = $this->model->find($id);
        ($data->active == constLang('active_true') ?
            $change = ['active' => constLang('active_false')] :
            $change = ['active' => constLang('active_true')]);

        $update = $data->update($change);
        if ($update) {
            generateAccessesTxt(
                date('H:i:s').utf8_decode(
                " Alterou o status da imagen do banner para ".$data->active)
            );

            ($data->status == 'Ativo' ? $class = 'button icon-tick green-gradient' : $class = 'button icon-tick red-gradient');

            $out = array(
                "success"    => true,
                "message"    => "{$message['status_true']} para {$data->active}",
                "class"      => $class
            );               

        } else {
            $out = array(
                "success"    => false,
                "message"    => "{$message['status_false']} para {$change['active']}"
            );
        }

        return $out;
    }

    /**
     * Retorna o input ordem referente ao banner
     *
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
     *
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
            $message = "{$messages['order_true']} para {$data->order}";
            generateAccessesTxt(date('H:i:s').utf8_decode(
                'Alterou a ordem da imagem do banner para '.$data->order)
            );
        } else {
            $success = false;
            $message = $messages['order_false'];
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