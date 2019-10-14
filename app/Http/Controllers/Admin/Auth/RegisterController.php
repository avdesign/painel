<?php

namespace AVDPainel\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Password;


use AVDPainel\Http\Requests\Admin\AdminRequest as ReqModel;
use AVDPainel\Http\Requests\Admin\MyProfileRequest as ReqMyProfile;
use AVDPainel\Interfaces\Admin\AdminInterface as InterModel;
use AVDPainel\Interfaces\Admin\AdminAccessInterface as InterAccess;
use AVDPainel\Interfaces\Admin\ConfigProfileInterface as InterProfile;
use AVDPainel\Interfaces\Admin\ConfigSystemInterface as InterConfigSystem;
use AVDPainel\Interfaces\Admin\AdminPermissionInterface as InterAdminPermission;


use AVDPainel\Http\Controllers\Controller;

class RegisterController extends Controller
{
    //use RegistersUsers;

    protected $ability = 'model-admins';
    protected $view    = 'backend.admins';
    protected $messages;


    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    //protected $redirectTo = 'painel/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(
        InterAccess $access,
        InterProfile $profile,
        InterModel $interModel,
        InterConfigSystem $confAdmin,
        InterAdminPermission $permissions)
    {
        $this->middleware('auth:admin');

        $this->access      = $access;
        $this->profile     = $profile;
        $this->confAdmin   = $confAdmin;
        $this->interModel  = $interModel;
        $this->permissions = $permissions;
    }

    /**
     * Init page
     *
     * @return \Illuminate\Http\Response
     */
    protected function index()
    {
        if( Gate::denies("{$this->ability}-view") ) {
            return view("backend.erros.message-401");
        }

        $register = ["last_url" => 'admins'];
        $this->access->update($register);

        $confAdmin = $this->confAdmin->get();
        $data      = $this->interModel->get();
        $title     = $this->messages['title_index'];


        return view("{$this->view}.index", compact('data', 'title', 'confAdmin'));
    }

    /**
     * Table Users
     *
     * @return json
     */
    protected function data(Request $request)
    {
        if( Gate::denies("{$this->ability}-view") ) {
            return view("backend.erros.message-401");
        }

        $data  = $this->interModel->getAll($request);

        return response()->json($data);
    }

    /**
     * Form create.
     *
     * @return \Illuminate\Http\Response
     */
    protected function create()
    {

        if( Gate::denies("{$this->ability}-create") ) {
            return view("backend.erros.message-401");
        }

        $options = $this->profile->pluck();

        return view("{$this->view}.form-create", compact('options'));
    }

    /**
     * Save user.
     *
     * @param  \AVDPainel\Http\Requests\Admin\AdminRequest  $request
     * @return \Illuminate\Http\Response
     */
    protected function store(ReqModel $request)
    {
        if( Gate::denies("{$this->ability}-create") ) {
            return view("backend.erros.message-401");
        }

        $dataForm = $request->all();
        $profile  = $this->profile->setId($dataForm['profile_id']);
        $dataForm['profile']  = $profile->name;


        //Inicia o Database Transaction
        DB::beginTransaction();

        $data = $this->interModel->create($dataForm);
        if ($data) {

            if ($data->active == constLang('active_true')) {

                $config = [
                    'admin_id' => $data->id,
                    'table_color' => 'anthracite-gradient',
                    'table_color_sel' => 'anthracite-gradient',
                    'table_limit' => 10,
                    'table_open_details' => 'td.details-control'
                ];

                if ( $this->confAdmin->create($config) ) {
                    $i=0;
                    foreach ($profile->permissions as $val) {
                        $insert = [
                            "module_id" => $val->module_id,
                            "admin_id" => $data->id,
                            "profile_id" => $dataForm['profile_id'],
                            "permission_id" => $val->id,
                            "name" => $val->name,
                            "label" => $val->label,
                        ];
                        if ( !$this->permissions->create($insert) ) {
                            $i++;
                        }
                    }

                    if ($i >= 1) {
                        DB::rollBack();
                        $success = false;
                        $message = 'Não foi possível criar as permissões.';
                    } else {
                        $register = [
                            "admin_id" => $data->id,
                            "last_ip" => '',
                            "last_url" => '/',
                            "last_logout" => '',
                            "qty_visits" => 0
                        ];

                        if ( $this->access->create($register) ) {

                            DB::commit();
                            $success = true;
                            $message = 'O usuário foi cadastrado.';

                        } else {

                            DB::rollBack();
                            $success = false;
                            $message = 'Não foi possível criar o acesso.';
                        }
                    }
                } else {

                    DB::rollBack();
                    $success = false;
                    $message = 'Não foi possível criar a configuração padrão.';
                }
            }

        } else {
            $success = false;
            $message = 'Não foi possível criar o usuário.';
        }

        $out = array(
            "success" => $success,
            "message" => $message
        );

        return response()->json($out);
    }

    /**
     * Form edit
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    protected function edit($id)
    {
        if( Gate::denies("{$this->ability}-update") ) {
            return view("backend.erros.message-401");
        }

        $data    = $this->interModel->setId(numLetter($id));
        $code    = numLetter($data->id, 'letter');
        $options = $this->profile->pluck();

        return view("{$this->view}.form-edit", compact('data', 'code', 'options'));
    }

    /**
     * Get user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    protected function show($id)
    {
        if( Gate::denies("{$this->ability}-profile") ) {
            return view("backend.erros.message-401");
        }

        $data = $this->interModel->setId(numLetter($id));

        foreach ($data->photo as $item) {
            $file = $item->id;
        }

        $count = count($data->photo);

        return view("{$this->view}.myprofile", compact('data', 'id', 'count', 'file'));

    }

    /**
     * Update user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    protected function updateProfile(ReqMyProfile $request, $id)
    {
        if( Gate::denies("{$this->ability}-profile") ) {
            return view("backend.erros.message-401");
        }

        $dataForm = $request->all();
        if (isset($dataForm['reset-password'])) {
            $dataForm['password'] = $dataForm['password'];
        } else {
            unset($dataForm['password']);
        }


        if( $this->interModel->updateProfile($dataForm, numLetter($id)) ) {
            $success = true;
            $message = 'Seus dados foram alterado.';
        } else {
            $success = false;
            $message = 'Não foi possível alterar seus dados.';
        }

        $out = array(
            "success" => $success,
            "message" => $message
        );
        return response()->json($out);


    }


    /**
     * Update user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    protected function update(ReqModel $request, $id)
    {
        if( Gate::denies("{$this->ability}-update") ) {
            return view("backend.erros.message-401");
        }

        DB::beginTransaction();

        $id       = numLetter($id);
        $dataForm = $request->all();
        $profile  = $this->profile->setId($dataForm['profile_id']);
        $count    = count($this->permissions->getFild('admin_id', $id));
        if (isset($request['reset-password'])) {
            if ($dataForm['password'] != $dataForm['password_confirmation']) {
                return response()->json(["success" => false, "message" => 'As senhas não coincidem.']);
            }

        } else {
            unset($dataForm['password']);
        }

        if( $this->interModel->update($dataForm, $id) ) {
            if ($dataForm['active'] == constLang('active_true')) {
                if ( !$this->permissions->deleteAdmin($id) && $count > 0) {
                    DB::rollBack();
                    $success = false;
                    $message = 'Não removeu as permissões anteriores.Ativo';
                } else {
                    $i=0;
                    foreach ($profile->permissions as $val) {
                        $insert = [
                            "module_id" => $val->module_id,
                            "admin_id" => numLetter($id),
                            "profile_id" => $profile->id,
                            "permission_id" => $val->id,
                            "name" => $val->name,
                            "label" => $val->label
                        ];

                        if( !$this->permissions->create($insert) ) {
                            $i++;
                        }
                    }

                    if ($i >= 1) {
                        DB::rollBack();
                        $success = false;
                        $message = 'Não foi possível criar as permissões.';
                    } else {
                        DB::commit();
                        $success = true;
                        $message = 'Os dados de registro foi alterado.';
                    }
                }

            } else {
                if( !$this->permissions->deleteAdmin($id)  && $count > 0) {
                    DB::rollBack();
                    $success = false;
                    $message = 'Não removeu as permissões anteriores.inativo';
                } else {
                    DB::commit();
                    $success = true;
                    $message = 'Os dados de registro foi alterado.';
                }
            }
        } else {
            $success = false;
            $message = 'Não foi possível aterar o registro do usuário.';
        }

        $out = array(
            "success" => $success,
            "message" => $message
        );
        return response()->json($out);
    }

    /**
     * Delete user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if( Gate::denies("{$this->ability}-delete") ) {
            return view("backend.erros.message-401");
        }

        DB::beginTransaction();

        $id    = numLetter($id);
        $count = count($this->permissions->getFild('admin_id', $id));
        if ( $this->interModel->delete($id) ) {
            $this->permissions->deleteAdmin($id);
            DB::commit();
            $success = true;
            $message = 'O usuário foi excluido.';

        } else {
            DB::rollBack();
            $success = false;
            $message = 'Não foi possível excluir o usuário';
        }

        $out = array(
            "success" => $success,
            "message" => $message
        );

        return response()->json($out);
    }

    /**
     * Init page
     *
     * @return \Illuminate\Http\Response
     */
    protected function excludeds()
    {
        if( Gate::denies("{$this->ability}-excluded") ) {
            return view("backend.erros.message-401");
        }

        $title     = 'Usuários Excluidos';
        $confAdmin = $this->confAdmin->get();

        return view("{$this->view}.excludeds", compact('title', 'confAdmin'));
    }

    /**
     * Table users excluded.
     *
     * @return json
     */
    protected function dataExcluded(Request $request)
    {
        if( Gate::denies("{$this->ability}-excluded") ) {
            return view("backend.erros.message-401");
        }

        $data = $this->interModel->excluded($request);
        return response()->json($data);
    }

    /**
     * Reactivate user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  action
     * @param  int  id
     * @return \Illuminate\Http\Response
     */
    protected function reactivateExcluded(Request $request)
    {
        if( Gate::denies("{$this->ability}-reactivate") ) {
            return view("backend.erros.message-401");
        }

        if ($request['action'] == 'reactivate') {

            DB::beginTransaction();

            $id = numLetter($request['user']);
            if ( $this->interModel->reactivate($id) ){

                $user    = $this->interModel->setId($id);
                $profile = $this->profile->getFild('name', $user->profile);
                $i=0;
                foreach ($profile->permissions as $val) {
                    $insert = [
                        "module_id" => $val->module_id,
                        "admin_id" => $user->id,
                        "profile_id" => $profile->id,
                        "permission_id" => $val->id,
                        "name" => $val->name,
                        "label" => $val->label,
                    ];
                    if ( !$this->permissions->create($insert) ) {
                        $i++;
                    }
                }

                if ($i >= 1) {
                    DB::rollBack();
                    $success = false;
                    $message = 'Não foi possível criar as permissões.';
                } else {
                    DB::commit();
                    $success = true;
                    $message = 'O usuário foi reativado.';
                }


            } else {
                $success = false;
                $message = 'Não foi possível reativar.';
            }
        }
        $out = array(
            "success" => $success,
            "message" => $message
        );

        return response()->json($out);
    }

    /**
     * Exibir o formulário para solicitar um link de redefinição de senha.
     *
     * @return \Illuminate\Http\Response
     */
    protected function showLinkRequestForm($id)
    {
        if( Gate::denies("{$this->ability}-password-update") ) {
            return view("backend.erros.message-401");
        }

        $data = $this->interModel->setId(numLetter($id));

        return view("backend.auth.passwords.email", compact('data'));
    }

    /**
     * Send a reset link to the given user.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function sendResetLinkEmail(Request $request)
    {
        $this->validateEmail($request);

        $response = $this->broker()->sendResetLink(
            $request->only('email')
        );

        return $response == Password::RESET_LINK_SENT
            ? $this->sendResetLinkResponse($response)
            : $this->sendResetLinkFailedResponse($request, $response);
    }

    /**
     * Validate the email for the given request.
     *
     * @param \Illuminate\Http\Request  $request
     * @return void
     */
    protected function validateEmail(Request $request)
    {
        $this->validate($request, ['email' => 'required|email']);
    }

    /**
     * Get the response for a successful password reset link.
     *
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendResetLinkResponse($response)
    {
        return response()->json([
            'success' => true,
            'message' => trans($response)
        ]);

    }

    /**
     * Get the response for a failed password reset link.
     *
     * @param  \Illuminate\Http\Request
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendResetLinkFailedResponse(Request $request, $response)
    {
        return response()->json([
            'success' => false,
            'message' => trans($response)
        ]);
    }

    /**
     * Obter o broker para ser usado durante a reinicialização da senha.
     *
     * @return \Illuminate\Contracts\Auth\PasswordBroker
     */
    public function broker()
    {
        return Password::broker('admins');
    }


}
