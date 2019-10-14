<?php

namespace AVDPainel\Http\Controllers\Admin;


use AVDPainel\Interfaces\Admin\UserAddressInterface as InterModel;
use AVDPainel\Interfaces\Admin\UserInterface as InterUser;
use AVDPainel\Interfaces\Admin\StateInterface as InterState;
use AVDPainel\Http\Requests\Admin\UserAddressRequest;

use AVDPainel\Interfaces\Admin\ConfigSystemInterface as ConfigSystem;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use AVDPainel\Http\Controllers\Controller;






class UserAddressController extends Controller
{
    protected $ability  = 'account';
    protected $view     = 'backend.accounts.address';
    protected $last_url;
    protected $messages;

    public function __construct(
        InterUser $interUser,
        InterModel $interModel,
        InterState $interState,
        ConfigSystem $confUser)
    {
        $this->middleware('auth:admin');

        $this->confUser       = $confUser;
        $this->interUser      = $interUser;
        $this->interModel     = $interModel;
        $this->interState     = $interState;
        $this->messages       = array(
            'title_index'     => 'Endereço',
            'title_create'    => 'Adicionar Endereço',
            'title_edit'      => 'Editar Endereço',
            'update_true'     => 'O endereço foi altearado.',
            'update_false'    => 'Não foi possível alterar o cliente.',
            'delete_true'     => 'O cliente foi excluido.',
            'delete_false'    => 'Não foi possível excluir o cliente.',
            'store_true'      => 'O cliente foi cadastrado.',
            'store_false'     => 'Não foi possível cadastrar o cliente.',
            'count_false'     => 'Este cliente já tem 2 endereços cadastrados, limite(2)'
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

        $user      = $this->interUser->setId($id);
        $addresses = $user->adresses;

        return view("{$this->view}.index",compact('addresses','user'));
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

        $user   = $this->interUser->setId($id);
        $states = $this->interState->pluck('name', 'uf');


        return view("{$this->view}.form-create",compact('user', 'states'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserAddressRequest $request, $id)
    {
        if( Gate::denies("{$this->ability}-create") ) {
            return view("backend.erros.message-401");
        }

        $dataForm = $request['address'];
        $dataForm['user_id'] = intval($id);

        $create = $this->interModel->create($dataForm);
        if ($create >= 2) {
            $success = false;
            $message = $this->messages['count_false'];
        } elseif ($create == 1) {
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
    public function show($id,$user_id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $user_id)
    {
        if( Gate::denies("{$this->ability}-update") ) {
            return view("backend.erros.message-401");
        }

        $data   = $this->interModel->setId($id);
        $states = $this->interState->pluck('name', 'uf');


        return view("{$this->view}.form-edit",compact('data', 'states'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserAddressRequest $request, $id, $user_id)
    {
        if( Gate::denies("{$this->ability}-update") ) {
            return view("backend.erros.message-401");
        }

        $dataForm = $request['address'];

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
    public function destroy($id)
    {
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

        $user      = $this->interUser->setId($id);
        $addresses = $user->adresses;

        return view("{$this->view}.refresh",compact('addresses'));
    }


}
