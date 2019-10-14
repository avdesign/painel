<?php

namespace AVDPainel\Http\Controllers\Admin;


use AVDPainel\Http\Controllers\Controller;
use AVDPainel\Interfaces\Admin\AdminAccessInterface as InterAccess;
use AVDPainel\Interfaces\Admin\ConfigSystemInterface as InterModel;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ConfigController extends Controller
{
    protected $ability  = 'config';
    protected $view     = 'backend.settings';


    /**
     * Acesso e personalização do sistema.
     *
     * @return void
     */
    public function __construct(
        InterAccess $access,
        InterModel $interModel)
    {
        $this->middleware('auth:admin');

        $this->access     = $access;
        $this->interModel = $interModel;

    }


    /**
     * Página inicial das configurações do sistema.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if( Gate::denies("{$this->ability}-view") ) {
            return view("backend.erros.message-401");
        }

        $register = ["last_url" => 'config/system'];
        $this->access->update($register);

        return view("{$this->view}.index");
    }

    /**
     * Personalizar cores do sistema.
     *
     * @return \Illuminate\Http\Response
     */
    public function colorSystem()
    {

        $register = ["last_url" => 'config/color/system'];
        $this->access->update($register);

        $data = $this->interModel->get();

        return view("{$this->view}.colors.index", compact('data'));
    }


    public function colorUpdate(Request $request)
    {
        $dataForm = $request->All();
        $update   = $this->interModel->update($dataForm);

        return response()->json($update);
    }


    /**
     * Folders: Seguranca e Permissões
     *
     * @return \Illuminate\Http\Response
     */
    public function folders($name)
    {
        return view("{$this->view}.folders.{$name}");
    }

}
