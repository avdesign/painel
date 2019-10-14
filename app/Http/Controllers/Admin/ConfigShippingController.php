<?php

namespace AVDPainel\Http\Controllers\Admin;

use AVDPainel\Interfaces\Admin\AdminAccessInterface as InterAccess;
use AVDPainel\Interfaces\Admin\ConfigShippingInterface as InterModel;
use AVDPainel\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;


class ConfigShippingController extends Controller
{

    protected $ability  = 'config-shipping';
    protected $view     = 'backend.settings.shippings';
    protected $last_url;
    protected $messages;


    public function __construct(
        InterAccess $access,
        InterModel $interModel)
    {
        $this->middleware('auth:admin');

        $this->last_url = array("last_url" => "config/shippings");


        $this->access     = $access;
        $this->interModel = $interModel;
        $this->messages   = array(
            "name.required" => "O método é obrigatório",
            "name.unique" => "Esta método já se encontra utilizado.",
            "description.required" => "A descrição é obrigatória.",
            "order.required" => "A ordem é obrigatória."
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if( Gate::denies("{$this->ability}-view") ) {
            return view("backend.erros.message-401");
        }

        $this->access->update($this->last_url);

        $methods      = $this->interModel->getAll();
        $title        = 'Método de Envio';

        return view("{$this->view}.index", compact('methods', 'title'));    
    }

    /**
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if( Gate::denies("{$this->ability}-create") ) {
            return view("backend.erros.message-401");
        }

        return view("{$this->view}.form-create");

    }

    /**
     * Gravar no banco de dados.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if( Gate::denies("{$this->ability}-create") ) {
            return view("backend.erros.message-401");
        }

        $this->interModel->rules($request, $this->messages);

        $dataForm = $request->all();

        $create = $this->interModel->create($dataForm);

        if ($create) {
            $success = true;
            $message = 'O método foi adicionado.';
        } else {
            $success = false;
            $message = 'Não foi possível adicionar o método.';
        }

        $out = array(
            'success' => $success, 
            'message' => $message 
        );

        return response()->json($out);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if( Gate::denies("{$this->ability}-view") ) {
            return view("backend.erros.message-401");
        }

        $methods      = $this->interModel->getAll();

        return view("{$this->view}.show", compact('methods'));    
    }

    /**
     * Form configurações dos métodos de envio.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if( Gate::denies("{$this->ability}-update") ) {
            return view("backend.erros.message-401");
        }

        $data  = $this->interModel->setId($id);
        $title = 'Configuração do Frete';

        return view("{$this->view}.form-edit", compact('data', 'title'));
    }

    /**
     * Alterar as configurações dos produtos.
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
            $message = 'O método foi alterado.';
        } else {
            $success = false;
            $message = 'Não foi possível alterar o método.';
        }

        $out = array(
            'success' => $success,
            'message' => $message
        );

        return response()->json($out);
    }

    /**
     * Excluir o método.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if( Gate::denies("{$this->ability}-delete") ) {
            return view("backend.erros.message-401");
        }

        $delete = $this->interModel->delete($id);

        if( $delete ) {
            $success = true;
            $message = 'O método foi excluido.';
        } else {
            $success = false;
            $message = 'Não foi possível excluir o método.';
        }

        $out = array(
            "success" => $success,
            "message" => $message
        );

        return response()->json($out);
    }
}
