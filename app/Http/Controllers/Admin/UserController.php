<?php

namespace AVDPainel\Http\Controllers\Admin;

use AVDPainel\Http\Controllers\Controller;
use AVDPainel\Events\UserAddressCreatedEvent;
use AVDPainel\Http\Requests\Admin\UserRequest;
use AVDPainel\Interfaces\Admin\UserInterface as InterModel;
use AVDPainel\Interfaces\Admin\AdminInterface as InterAdmin;
use AVDPainel\Interfaces\Admin\StateInterface as InterState;
use AVDPainel\Interfaces\Admin\UserAddressInterface as InterAddress;

use AVDPainel\Interfaces\Admin\AdminAccessInterface as InterAccess;
use AVDPainel\Interfaces\Admin\ConfigSystemInterface as ConfigSystem;
use AVDPainel\Interfaces\Admin\ConfigProfileClientInterface as InterProfile;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;


class UserController extends Controller
{
    protected $ability  = 'account';
    protected $view     = 'backend.accounts';
    protected $last_url;
    protected $messages;

    public function __construct(
        InterAccess $access,
        InterModel $interModel,
        InterAdmin $interAdmin,
        InterState $interState,
        ConfigSystem $confUser,
        InterAddress $interAddress,
        InterProfile $interProfile)
    {
        $this->middleware('auth:admin');

        $this->access         = $access;
        $this->confUser       = $confUser;
        $this->interModel     = $interModel;
        $this->interAdmin     = $interAdmin;
        $this->interState     = $interState;
        $this->interAddress   = $interAddress;
        $this->interProfile   = $interProfile;
        $this->last_url       = array('last_url' => 'accounts');
        $this->messages       = array(
            'title_index'       => 'Clientes',
            'title_create'      => 'Adicionar Cliente',
            'title_edit'        => 'Editar Cliente',
            'title_excluded'    => 'Clientes Excluidos',
            'update_true'       => 'O cliente foi altearado.',
            'update_false'      => 'Não foi possível alterar o cliente.',
            'delete_true'       => 'O cliente foi excluido.',
            'delete_false'      => 'Não foi possível excluir o cliente.',
            'store_true'        => 'O cliente foi cadastrado.',
            'store_false'       => 'Não foi possível cadastrar o cliente.',
            'address_false'     => 'Não foi possível cadastrar o endereço.',
            'reactivate_true'   => 'O Cliente foi reativado.',
            'reactivate_false'  => 'Não foi possível reativar o cliente.'
        );

    }

    public function index()
    {
        if( Gate::denies("{$this->ability}-view") ) {
            return view("backend.erros.message-401");
        }

        $this->access->update($this->last_url);

        $data         = $this->interModel->get();
        $title        = $this->messages['title_index'];
        $confUser     = $this->confUser->get();
        $title_create = $this->messages['title_create'];


        return view("{$this->view}.index", compact(
            'data', 'title', 'title_create', 'confUser'
        ));
    }

    /**
     * @param Request $request
     * @return json
     */
    public function data(Request $request)
    {
        if( Gate::denies("{$this->ability}-view") ) {
            return view("backend.erros.message-401");
        }

        $data = $this->interModel->getAll($request);

        return response()->json($data);
    }

    /**
     * @param $id
     * @return View
     */
    public function profile($id)
    {
        if( Gate::denies("{$this->ability}-view") ) {
            return view("backend.erros.message-401");
        }

        $data = $this->interModel->setId($id);

        return view("{$this->view}.details", compact('data'));
    }

    /**
     * Form para adicionar
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if( Gate::denies("{$this->ability}-create") ) {
            return view("backend.erros.message-401");
        }

        $profiles = $this->interProfile->pluck('name', 'id');
        $admins   = $this->interAdmin->pluck('name', 'id');
        $states   = $this->interState->pluck('name', 'uf');

        return view("{$this->view}.forms.account-create", compact(
            'title', 'profiles','admins','states'
        ));

    }

    /**
     * Carregar formulário para criação do cliente
     * @param $id
     * @return View
     */
    public function loadProfile($opc)
    {
        if( Gate::denies("{$this->ability}-view") ) {
            return view("backend.erros.message-401");
        }

        return view("{$this->view}.forms.profile-{$opc}-create");
    }

    /**
     * @param $opc
     * @param $id
     * @return View
     */
    public function loadUpdateProfile($opc, $id)
    {
        if( Gate::denies("{$this->ability}-update") ) {
            return view("backend.erros.message-401");
        }

        $data = $this->interModel->setId($id);

        return view("{$this->view}.forms.profile-{$opc}-edit",compact('data'));
    }

    /**
     * @param UserRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserRequest $request)
    {
        if( Gate::denies("{$this->ability}-create") ) {
            return view("backend.erros.message-401");
        }

        $dataForm         = $request->all();
        $address          = $dataForm['address'];
        $user             = $dataForm['user'];
        $user['ip']       = $request->ip();


        $create = $this->interModel->create($user);

        if ($create) {

            $address['user_id']  = $create->id;
            $address['delivery'] = 1;

            $add = $this->interAddress->create($address);

            //event(new UserAddressCreatedEvent($address));
            if ($add) {
                $success = true;
                $message = $this->messages['store_true'];
            } else {
                $success = false;
                $message = $this->messages['address_false'];
            }
        }
        else {
            $success = false;
            $message = $this->messages['store_false'];
        }


        $out = array(
            "success" => $success,
            "message" => $message
        );

        return response()->json($out);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function edit($id)
    {
        if( Gate::denies("{$this->ability}-update") ) {
            return view("backend.erros.message-401");
        }

        $data     = $this->interModel->setId($id);
        $profiles = $this->interProfile->pluck('name', 'id');
        $admins   = $this->interAdmin->pluck('name', 'id');


        $title = $this->messages['title_edit'];

        return view("{$this->view}.forms.profile-edit", compact('data', 'profiles', 'admins', 'title'));

    }

    /**
     * @param UserRequest $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UserRequest $request, $id)
    {
        if( Gate::denies("{$this->ability}-update") ) {
            return view("backend.erros.message-401");
        }

        $dataForm = $request->all();
        $user     = $dataForm['user'];
        unset($user['id']);

        if (isset($user['reset_password'])) {
            $user['password'] = $user['password'];
        } else {
            unset($user['password']);
        }
        $update = $this->interModel->update($user, $id);
        if( $update ) {
            $success = true;
            $message = $this->messages['update_true'];
        } else {
            $success = false;
            $message = $this->messages['update_false'];
        }

        $out = array(
            "success" => $success,
            "message" => $message
        );
        return response()->json($out);
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        if( Gate::denies("{$this->ability}-delete") ) {
            return view("backend.erros.message-401");
        }

        $delete = $this->interModel->delete($id);

        if( $delete ) {
            $success = true;
            $message = $this->messages['delete_true'];
            $deleted = $delete;

        } else {
            $success = false;
            $message = $this->messages['delete_false'];
            $deleted = false;
        }

        $out = array(
            "success" => $success,
            "message" => $message,
            "deleted" => $deleted
        );

        return response()->json($out);
    }

    /**
     * Excluded
     * @return View
     */
    public function show()
    {
        if( Gate::denies("{$this->ability}-delete") ) {
            return view("backend.erros.message-401");
        }

        $data         = $this->interModel->get();
        $title        = $this->messages['title_excluded'];
        $confUser     = $this->confUser->get();


        return view("{$this->view}.excluded", compact('data', 'title', 'confUser'));
    }

    /**
     * Excluded data
     */
    public function dataExcluded(Request $request)
    {
        if( Gate::denies("{$this->ability}-delete") ) {
            return view("backend.erros.message-401");
        }

        $data = $this->interModel->getExcluded($request);

        return response()->json($data);
    }


    public function reactivate(Request $request, $id)
    {
        if( Gate::denies("{$this->ability}-delete") ) {
            return view("backend.erros.message-401");
        }

        $reactivate = $this->interModel->reactivate($id);
        if($reactivate) {
            $success = true;
            $message = $this->messages['reactivate_true'];
        } else {
            $success = false;
            $message = $this->messages['reactivate_false'];
        }

        $out = array(
            "success" => $success,
            "message" => $message
        );
        return response()->json($out);
    }




}
