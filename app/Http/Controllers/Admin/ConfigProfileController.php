<?php

namespace AVDPainel\Http\Controllers\Admin;

use AVDPainel\Models\Admin\Admin as Users;

use AVDPainel\Http\Controllers\AdminAjaxTablesController;
use AVDPainel\Interfaces\Admin\AdminAccessInterface as InterAccess;
use AVDPainel\Interfaces\Admin\ConfigProfileInterface as InterModel;
use AVDPainel\Interfaces\Admin\ConfigSystemInterface as InterConfigSystem;

use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;


class ConfigProfileController extends AdminAjaxTablesController
{
    
    protected $ability = 'config-profile';
    protected $view    = 'backend.settings.profiles';
    protected $users;
    protected $last_url;
    protected $messages;


    public function __construct(
        Users $users,
        InterAccess $access,
        InterModel $interModel,
        InterConfigSystem $confUser)
    {
        $this->middleware('auth:admin');

        $this->users      = $users;
        $this->access     = $access;
        $this->confUser   = $confUser;
        $this->interModel = $interModel;
        $this->last_url   = array('last_url' => 'config/profiles');
        $this->messages = array(
            'name.required'      => 'O perfil é obrigatório.',
            'name.unique'        => 'Este perfil já se encontra utilizado.',
            'label.required'     => 'A descrição é obrigatória.',
            'title_index'        => 'Perfis dos usuários',
            'title_create'       => 'Adicionar Perfil',
            'title_edit'         => 'Editar Perfil',
            'store_true'         => 'O perfil foi cadastrado.',
            'store_false'        => 'Não foi possível cadastrar o perfil.',
            'update_true'        => 'O perfil foi alterado.',
            'update_false'       => 'Não foi possível alterar o perfil.',
            'delete_true'        => 'O perfil foi excluida.',
            'delete_false'       => 'Não foi possível excluir o perfil.'
        );
    }

    public function data(Request $request)
    {
        if( Gate::denies("{$this->ability}-view") ) {
            return view("backend.erros.message-401");
        }

        $data = $this->interModel->getAll($request);

            
        return response()->json($data);     
    }

    /**
     * distinct('admin_id') Não repetir registros (apenas um).
     * 
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function showUsers(Request $request, $id)
    {
        if( Gate::denies("{$this->ability}-view") ) {
            return view("backend.erros.message-401");
        }

        $data    = $this->interModel->setId($id);
        $active  = $data->users()->distinct('admin_id')->get();

        return view("{$this->view}.users", compact('data', 'active'));
    }


    /**
     * all(); Obter todos
     * doesntHave('profiles')->get(); Obter apenas os que não tem perfil.
     * whereNotIn('id', [1,2,3])->get(); Obter os que não estão vinculados.
     * ->toSql() Debugar o sql.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function createUsers($id)
    {
        if( Gate::denies("{$this->ability}-create") ) {
            return view("backend.erros.message-401");
        }

        $data  = $this->interModel->setId($id);
        $users = $this->users->whereNotIn('id', function($query) use ($id) {
            $query->select("admin_config_profile.admin_id");
            $query->from("admin_config_profile");
            $query->whereRaw("admin_config_profile.config_profile_id = {$id}");
        })->get();

        
        $title  = 'Adicionar usuários ao perfil:';

        return view("{$this->view}.form-users", compact('data', 'users', 'title'));
    }


   /**
     * Adiciona o(s) usuário(s) ao perfil
     *
     * @param  int  $id
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeUsers(Request $request, $id)
    {
        if( Gate::denies("{$this->ability}-create") ) {
            return view("backend.erros.message-401");
        }

        $users = $request->get('users');

        $total = count($users);
        if (!$total) {
            $success = false ;
            $message = 'Selecione pelo menos um usuário.';
        } else {
            $add = $this->interModel->addUsers($users, $id);
            if ($add) {
                $success = true;
                $message = 'Usuário adicionado.';
            } else {
                $success = false;
                $message = 'Não foi possível adicionar o usuário.';
            }
        }
        $out = array(
            'success' => $success, 
            'message' => $message 
        );

        return response()->json($out);
    }
    

    /**
     * Remover usuário do perfil
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteUser(Request $request, $id, $iduser)
    {
        if( Gate::denies("{$this->ability}-delete") ) {
            return view("backend.erros.message-401");
        }

        $name = $request['name'];

        

        $delete =  $this->interModel->removeUser($id, $iduser, $name);

        if ($delete) {
            $success = true;
            $message = 'Usuário excluido.';
        } else {
            $success = fase;
            $message = 'Erro ao excluir usuário.';
        }

        $out = array(
            'success' => $success, 
            'message' => $message 
        );

        return response()->json($out);
    }
}
