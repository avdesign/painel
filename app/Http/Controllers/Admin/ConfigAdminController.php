<?php

namespace AVDPainel\Http\Controllers\Admin;

use AVDPainel\Interfaces\Admin\AdminAccessInterface as InterAccess;
use AVDPainel\Interfaces\Admin\ConfigAdminInterface as InterModel;
use AVDPainel\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ConfigAdminController extends Controller
{

    protected $ability = 'config-admin';
    protected $view = 'backend.settings.images.admins';
    protected $last_url;
    protected $messages;


    public function __construct(
        InterAccess $access,
        InterModel $interModel)
    {
        $this->middleware('auth:admin');

        $this->interModel = $interModel;
        $this->messages = constLang('ConfigAdmin');
        $this->access   = $access;
        $this->last_url = array('last_url' => 'config/images/admins');
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit()
    {
        if (Gate::denies("{$this->ability}-update")) {
            return view("backend.erros.message-401");
        }

        $data  = $this->interModel->setId(1);
        $title = $this->messages['title'];
        return view("{$this->view}.form", compact('data', 'title'));
    }

    public function update(Request $request, $id)
    {

        if (Gate::denies("{$this->ability}-update")) {
            return view("backend.erros.message-401");
        }
        $this->access->update($this->last_url);


        $this->interModel->rules($request, $this->messages, $id);

        $dataForm = $request->all();
        $update = $this->interModel->update($dataForm, $id);
        if ($update) {
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
