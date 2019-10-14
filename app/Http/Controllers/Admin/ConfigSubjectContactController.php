<?php

namespace AVDPainel\Http\Controllers\Admin;

use AVDPainel\Interfaces\Admin\AdminAccessInterface as InterAccess;
use AVDPainel\Interfaces\Admin\ConfigSubjectContactInterface as InterModel;
use AVDPainel\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Gate;

class ConfigSubjectContactController extends Controller
{
    protected $ability  = 'config-subject';
    protected $view     = 'backend.settings.subjects';
    protected $last_url;

    public function __construct(
        InterAccess $access,
        InterModel $interModel)
    {
        $this->middleware('auth:admin');

        $this->interModel   = $interModel;
        $this->access       = $access;
        $this->last_url     = array("last_url" => "config/contact-subjects");
        $this->messages     = array(
            'label.required' => 'O Assunto é obrigatório.',
            'message.min'    => 'A mensagem é obrigatória, mínimo 10 caracteres.',
            'order.required' => 'A ordem é obrigatória.',
            'title_index'    => 'Contatos do Site',
            'title_create'   => 'Adicionar Assunto',
            'title_edit'     => 'Editar  Assunto',
            'success_create' => 'O assunto foi adicionado.',
            'success_update' => 'O assunto foi alterado.',
            'success_delete' => 'O assunto foi excluido.',
            'error'          => 'Houve um erro no servidor.',
            'delete_success' => 'O assunto foi excluido.',
            'delete_error'   => 'Não foi possível excluir o assunto.'
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

        $data         = $this->interModel->getAll();
        $title        = $this->messages['title_index'];
        $title_edit   = $this->messages['title_edit'];
        $title_create = $this->messages['title_create'];

        return view("{$this->view}.index", compact('title','title_create','title_edit','data'));
    }

    /**
     * Show the form for creating a new resource.
     *
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
     * Store a newly created resource in storage.
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

        $data = $this->interModel->create($dataForm);
        if ($data) {
            $success = true;
            $message = $this->messages['success_create'];
        } else {
            $success = false;
            $message = $this->messages['error'];
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
        if( Gate::denies("{$this->ability}-update") ) {
            return view("backend.erros.message-401");
        }

        $data = $this->interModel->setId($id);

        return view("{$this->view}.form-edit", compact('data'));

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if( Gate::denies("{$this->ability}-update") ) {
            return view("backend.erros.message-401");
        }
    }

    /**
     * Update the specified resource in storage.
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

        $this->interModel->rules($request, $this->messages);

        $dataForm = $request->all();

        $data = $this->interModel->update($dataForm, $id);
        if ($data) {
            $success = true;
            $message = $this->messages['success_update'];
        } else {
            $success = false;
            $message = $this->messages['error'];
        }

        $out = array(
            'success' => $success,
            'message' => $message
        );

        return response()->json($out);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if( Gate::denies("{$this->ability}-delete") ) {
            return view("backend.erros.message-401");
        }

        $data = $this->interModel->delete($id);
        if ($data) {
            $success = true;
            $message = $this->messages['success_delete'];
        } else {
            $success = false;
            $message = $this->messages['error'];
        }
        $out = array(
            'success' => $success,
            'message' => $message
        );

        return response()->json($out);

    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function loadSubjects()
    {
        $data         = $this->interModel->getAll();
        $title        = $this->messages['title_index'];
        $title_edit   = $this->messages['title_edit'];
        $title_create = $this->messages['title_create'];


        return view("{$this->view}.list", compact('title','title_create','title_edit','data'));
    }



}
