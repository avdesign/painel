<?php

namespace AVDPainel\Http\Controllers\Admin;

use AVDPainel\Interfaces\Admin\ConfigSystemInterface as ConfigSystem;
use AVDPainel\Interfaces\Admin\UserNoteInterface as InterModel;
use AVDPainel\Interfaces\Admin\UserInterface as InterUser;
use AVDPainel\Http\Requests\Admin\UserNoteRequest;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use AVDPainel\Http\Controllers\Controller;




class UserNoteController extends Controller
{
    protected $ability  = 'account';
    protected $view     = 'backend.accounts.notes';
    protected $last_url;
    protected $messages;

    public function __construct(
        InterUser $interUser,
        InterModel $interModel,
        ConfigSystem $confUser)
    {
        $this->middleware('auth:admin');

        $this->confUser       = $confUser;
        $this->interUser      = $interUser;
        $this->interModel     = $interModel;
        $this->messages       = array(
            'title_index'     => 'Observações',
            'title_create'    => 'Adicionar Observação',
            'title_edit'      => 'Editar Observação',
            'update_true'     => 'A observação foi altearada.',
            'update_false'    => 'Não foi possível alterar a observação.',
            'delete_true'     => 'A observação  foi excluida.',
            'delete_false'    => 'Não foi possível excluir a observação.',
            'store_true'      => 'A observação foi cadastrado.',
            'store_false'     => 'Não foi possível cadastrar a observação.'
        );

    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        if( Gate::denies("{$this->ability}-view") ) {
            return view("backend.erros.message-401");
        }

        $user    = $this->interUser->setId($id);
        $notes   = $user->notes()->orderBy('id', 'desc')->get();
        $title   = $this->messages['title_index'];
        $tcreate = $this->messages['title_create'];

        return view("{$this->view}.index",compact('notes','title','tcreate','user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        if( Gate::denies("{$this->ability}-create") ) {
            return view("backend.erros.message-401");
        }

        $user = $this->interUser->setId($id);

        return view("{$this->view}.form-create",compact('user'));

    }

    /**
     * @param UserNoteRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserNoteRequest $request, $id)
    {
        if( Gate::denies("{$this->ability}-create") ) {
            return view("backend.erros.message-401");
        }

        $dataForm = $request['notes'];
        $dataForm['user_id'] = intval($id);
        $dataForm['admin']  = auth()->user()->name;

        $create = $this->interModel->create($dataForm);
        if ($create) {
            $success = true;
            $message = $this->messages['store_true'];
        } else {
            $success = false;
            $message = $this->messages['store_false'];
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
       //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @param  int  $user_id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $user_id)
    {
        if( Gate::denies("{$this->ability}-update") ) {
            return view("backend.erros.message-401");
        }

        $data   = $this->interModel->setId($id);

        return view("{$this->view}.form-edit",compact('data'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserNoteRequest $request, $id)
    {
        if( Gate::denies("{$this->ability}-update") ) {
            return view("backend.erros.message-401");
        }

        $dataForm = $request['notes'];
        $dataForm['admin']  = auth()->user()->name;

        $data = $this->interModel->update($dataForm, $id);
        if ($data) {
            $success = true;
            $message = $this->messages['update_true'];
        } else {
            $success = true;
            $message = $this->messages['update_false'];
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
    public function destroy($id, $user_id)
    {
        $delete  = $this->interModel->delete($id);
        if ($delete) {
            $success = true;
            $message = $this->messages['delete_true'];
        } else {
            $success = true;
            $message = $this->messages['delete_false'];
        }

        $out = array(
            'success' => $success,
            'message' => $message
        );

        return response()->json($out);
    }


    /**
     * @param $id
     * @return View
     */
    public function refresh($id)
    {
        if( Gate::denies("{$this->ability}-view") ) {
            return view("backend.erros.message-401");
        }

        $user  = $this->interUser->setId($id);
        $notes = $user->notes;

        return view("{$this->view}.refresh",compact('notes'));
    }
}
