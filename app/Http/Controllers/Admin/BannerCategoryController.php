<?php

namespace AVDPainel\Http\Controllers\Admin;

use AVDPainel\Interfaces\Admin\ConfigCategoryInterface as InterConfig;
use AVDPainel\Interfaces\Admin\ImageCategoryInterface as InterModel;
use AVDPainel\Http\Controllers\AdminAjaxDataParamController;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class BannerCategoryController extends AdminAjaxDataParamController
{

    protected $ability = 'category-images';
    protected $view    = 'backend.categories.images';
    protected $upload;

    public function __construct(
        InterModel $interModel,
        InterConfig $interConfig)
    {
        $this->middleware('auth:admin');

        $this->interConfig   = $interConfig->setId(1);
        $this->interModel    = $interModel;

        $width    = $this->interConfig->width_banner;
        $height   = $this->interConfig->height_banner;
        $path     = $this->interConfig->path.$width.'x'.$height.'/';
        $disk     = storage_path('app/public/');
        $photoUrl = 'storage/'.$path;

        $this->upload  = array(
            'name'   => 'image',
            'type'   => 'banner',
            'width'  => $width,
            'height' => $height,
            'path'   => $path,
            'disk' => $disk,
            'photo_url' => $photoUrl,
            "btn"   => array(
                "create" => "Adicionar",
                "edit"   => "Editar",
                "status" => "Alterar Status",
                "delete" => "Excluir Imagem"
            )
        );

        $this->messages = array(
            'category_id.required'  => 'A categoria é obrigatória',
            'image.required'        => 'A imagem banner é obrigatória.',
            'image.image'           => 'O arquivo deverá conter uma imagem',
            'image.mimes'           => ' dos tipos jpg,gif,png.',
            'image.unique'          => 'Já existe banner para este categoria.',
            'type.required'         => 'O tipo é obrigatório',
            'status.required'       => 'O status é obrigatório',
            'title_index'           => 'Banner da Categoria',
            'delete_success'        => 'O banner foi excluido.',
            'delete_error'          => 'Não foi possível excluir o banner.',
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