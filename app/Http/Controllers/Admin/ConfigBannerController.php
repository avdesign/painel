<?php

namespace AVDPainel\Http\Controllers\Admin;

use AVDPainel\Interfaces\Admin\AdminAccessInterface as InterAccess;
use AVDPainel\Interfaces\Admin\ConfigBannerInterface as InterModel;
use AVDPainel\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ConfigBannerController extends Controller
{
    protected $ability  = 'config-banners';
    protected $view     = 'backend.settings.images.banners';
    protected $last_url;
    protected $messages;


    public function __construct(
        InterAccess $access,
        InterModel $interModel)
    {
        $this->middleware('auth:admin');

        $this->interModel = $interModel;
        $this->access     = $access;
        $this->last_url   = array("last_url" => "config/images/banners");
        $this->messages   = array(
            "path.required"         => "A pasta das imagens é obrigatória.",
            "width.required"        => "A largura da imagem é obrigatória.",
            "width.numeric"         => "Digite apenas números na largura da imagem.",
            "height.required"       => "A altura da imagem é obrigatória.",
            "height.numeric"        => "Digite apenas números na altura da imagem.",
        );
    }


    /**
     * Form configurações dos fabricantes.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit()
    {
        if( Gate::denies("{$this->ability}-view") ) {
            return view("backend.erros.message-401");
        }

        $data  = $this->interModel->setId(1);
        $title = 'Banners do site';
        return view("{$this->view}.form", compact('data', 'title'));
    }

    /**
     * Alterar as configurações dos banners.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        if( Gate::denies("{$this->ability}-update") ) {
            return view("backend.erros.message-401");
        }

        $this->interModel->rules($request, $this->messages, $id);

        $dataForm = $request->all();
        $update   = $this->interModel->update($dataForm, $id);
        if( $update ) {
            $success = true;
            $message = 'A configuração foi alterada.';
        } else {
            $success = false;
            $message = 'Não foi possível alterar.';
        }

        $out = array(
            'success' => $success,
            'message' => $message
        );

        return response()->json($out);
    }
}
