<?php

namespace AVDPainel\Http\Controllers\Admin;

use AVDPainel\Interfaces\Admin\ConfigSliderInterface as InterConfig;
use AVDPainel\Interfaces\Admin\AdminAccessInterface as InterAccess;

use AVDPainel\Interfaces\Admin\ImageSliderInterface as InterModel;
use AVDPainel\Http\Controllers\AdminAjaxDataParamController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ImageSliderController extends AdminAjaxDataParamController
{
    protected $ability = 'images-site';
    protected $view    = 'backend.sliders.images';
    protected $upload;
    protected $last_url;


    public function __construct(
        InterAccess $access,
        InterModel $interModel,
        InterConfig $interConfig)
    {

        $this->middleware('auth:admin');

        $this->interConfig   = $interConfig->setId(1);
        $this->interModel    = $interModel;
        $this->access        = $access;
        $this->last_url      = array("last_url" => "images/banner/banner");

        $width        = $this->interConfig->width;
        $height       = $this->interConfig->height;
        $width_thumb  = $this->interConfig->width_thumb;
        $height_thumb = $this->interConfig->height_thumb;
        $width_modal  = $this->interConfig->width_modal;
        $height_modal = $this->interConfig->height_modal;
        $path         = $this->interConfig->path.$width.'x'.$height.'/';
        $path_thumb   = $this->interConfig->path.$width_thumb.'x'.$height_thumb.'/';
        $disk         = storage_path('app/public/');
        $photoUrl     = 'storage/'.$path;

        $this->upload  = array(
            'type' => 'banner',
            'name' => 'image',
            'width' => $width,
            'height' => $height,
            'width_thumb' => $width_thumb,
            'height_thumb' => $height_thumb,
            'width_modal' => $width_modal,
            'height_modal' => $height_modal,
            'path' => $path,
            'path_thumb' => $path_thumb,
            'disk' => $disk,
            'photo_url' => $photoUrl,
            "btn"   => array(
                "create" => "Adicionar",
                "edit"   => "Editar",
                "order" => "Ordem",
                "status" => "Alterar Status",
                "delete" => "Excluir Imagem"
            )
        );

        $this->messages = array(
            'active.required'   => 'O status é obrigatório',
            'order.required'    => 'A ordem é obrigatória.',
            'image.image'       => 'O arquivo deverá conter uma imagem',
            'image.mimes'       => ' dos tipos jpg,gif,png.',
            'title_index'       => 'Imagem Slider',
            'delete_success'    => 'A imagem do slider foi excluida.',
            'delete_error'      => 'Não foi possível excluir a imagem.',
            'upload_false'      => 'Não foi possível fazer upload da imagem.',
            'success_update'    => 'Alteração feita com sucesso.',
            'error'             => 'Houve um erro no servidor.'
        );

    }


    public function status(Request $request, $id)
    {
        if( Gate::denies("{$this->ability}-update") ) {
            return view("backend.erros.message-401");
        }

        $dataForm = $request->all();
        $status = $this->interModel->status($id);

        return response()->json($status);
    }


    public function order($id)
    {
        if( Gate::denies("{$this->ability}-update") ) {
            return view("backend.erros.message-401");
        }

        $order = $this->interModel->getOrder($id);
        return view("{$this->view}-order", compact('order', 'id'));
    }


    public function updateOrder(Request $request)
    {
        if( Gate::denies("{$this->ability}-update") ) {
            return view("backend.erros.message-401");
        }
        $dataForm = $request->all();
        return $this->interModel->updateOrder($dataForm, $this->messages);
    }
}
