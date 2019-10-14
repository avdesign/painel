<?php

namespace AVDPainel\Http\Controllers\Admin;

use AVDPainel\Interfaces\Admin\ConfigSectionInterface as InterConfig;
use AVDPainel\Interfaces\Admin\ImageSectionInterface as InterModel;
use AVDPainel\Http\Controllers\AdminAjaxDataParamController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class FeaturedSectionController extends AdminAjaxDataParamController
{

    protected $ability = 'section-images';
    protected $view    = 'backend.sections.images';
    protected $upload;

    public function __construct(
        InterModel $interModel,
        InterConfig $interConfig)
    {
        $this->middleware('auth:admin');

        $this->interConfig   = $interConfig->setId(1);
        $this->interModel    = $interModel;

        $width    = $this->interConfig->width_featured;
        $height   = $this->interConfig->height_featured;
        $path     = $this->interConfig->path.$width.'x'.$height.'/';
        $disk     = storage_path('app/public/');
        $photoUrl = 'storage/'.$path;

        $this->upload  = array(
            'name'   => 'image',
            'type'   => 'featured',
            'width'  => $width,
            'height' => $height,
            'path'   => $path,
            'disk'   => $disk,
            'photo_url' => $photoUrl,
            "btn"   => array(
                "create" => "Adicionar",
                "edit"   => "Editar",
                "status" => "Alterar Status",
                "delete" => "Excluir Imagem"
            )
        );

        $this->messages = array(
            'section_id.required'   => 'A seção é obrigatória',
            'image.required'        => 'A imagem destaque é obrigatória.',
            'image.image'           => 'O arquivo deverá conter uma imagem',
            'image.mimes'           => ' dos tipos jpg,gif,png.',
            'image.unique'          => 'Já existe destaque para este seção.',
            'type.required'         => 'O tipo é obrigatório',
            'active.required'       => 'O status é obrigatório',
            'title_index'           => 'Destaque',
            'delete_success'        => 'O destaque foi excluido.',
            'delete_error'          => 'Não foi possível excluir o destaque.',
            'upload_false'          => 'Não foi possível fazer upload da imagem.'
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
}