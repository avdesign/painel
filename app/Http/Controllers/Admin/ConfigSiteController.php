<?php

namespace AVDPainel\Http\Controllers\Admin;

use AVDPainel\Interfaces\Admin\AdminAccessInterface as InterAccess;
use AVDPainel\Interfaces\Admin\ConfigSiteInterface as InterModel;


use AVDPainel\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ConfigSiteController extends Controller
{
    protected $profiles;

    protected $ability  = 'config-site';
    protected $view     = 'backend.settings.site';
    protected $last_url;

    public function __construct(
        InterAccess $access,
        InterModel $interModel)
    {
        $this->middleware('auth:admin');

        $this->interModel   = $interModel;

        $this->access       = $access;
        $this->last_url    = array("last_url" => "config/site");
    }


    /**
     * Form configurações do site.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if( Gate::denies("{$this->ability}-view") ) {
            return view("backend.erros.message-401");
        }

        $this->access->update($this->last_url);

        $data        = $this->interModel->setId($id);
        $title       = 'Configuração do Site';

        return view("{$this->view}.form", compact('data', 'title'));
    }

    /**
     * Alterar as configurações do site.
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

        $dataForm   = $request->all();
        $update = $this->interModel->update($dataForm, $id);

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
