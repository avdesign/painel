<?php

namespace AVDPainel\Http\Controllers\Admin;

use AVDPainel\Interfaces\Admin\AdminAccessInterface as InterAccess;
use AVDPainel\Interfaces\Admin\ConfigSectionInterface as InterModel;
use AVDPainel\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ConfigSectionController extends Controller
{

    protected $ability  = 'config-section';
    protected $view     = 'backend.settings.images.sections';
    protected $last_url;
    protected $messages;


    public function __construct(
        InterAccess $access,
        InterModel $interModel)
    {
        $this->middleware('auth:admin');

        $this->access     = $access;
        $this->interModel = $interModel;
        $this->messages   = array(
            "path.required"            => "A pasta das imagens é obrigatória.",
            "width_featured.required"  => "A largura da imagem destaque é obrigatória.",
            "width_featured.numeric"   => "Digite apenas números na largura imagem destaque.",
            "height_featured.required" => "A altura imagem destaque é obrigatória.",
            "height_featured.numeric"  => "Digite apenas números na largura imagem destaque.",
            "width_banner.required"    => "A largura do banner é obrigatória.",
            "width_banner.numeric"     => "Digite apenas números na largura do banner.",
            "height_banner.required"   => "A altura do banner é obrigatória.",
            "height_banner.numeric"    => "Digite apenas números na largura do banner.",
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

        $this->last_url = array("last_url" => "config/images/sections");
        $this->access->update($this->last_url);

        $data  = $this->interModel->setId(1);
        $title = 'Configuração das Seções';
        return view("{$this->view}.form", compact('data', 'title'));    
    }

    /**
     * Alterar as configurações dos pfabricantes.
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
