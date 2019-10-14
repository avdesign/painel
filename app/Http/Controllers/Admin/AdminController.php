<?php

namespace AVDPainel\Http\Controllers\Admin;

use AVDPainel\Interfaces\Admin\AdminInterface as InterModel;
use AVDPainel\Interfaces\Admin\ConfigModuleInterface as InterModule;
use AVDPainel\Interfaces\Admin\ConfigAdminInterface as InterConfig;
use AVDPainel\Interfaces\Admin\ConfigSystemInterface as InterConfigSystem;
use AVDPainel\Interfaces\Admin\AdminPermissionInterface as InterPermission;
use AVDPainel\Interfaces\Admin\ConfigProfileInterface as InterConfigProfile;
use AVDPainel\Interfaces\Admin\ConfigPermissionInterface as InterConfigPermission;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use AVDPainel\Http\Controllers\Controller;

use AVDPainel\Models\Admin\Admin;

class AdminController extends Controller
{

    protected $ability = 'model-admins';
    protected $view    = 'backend.admins';

    public function __construct(
        InterModel $interModel, 
        InterConfig $interConfig,
        InterModule $interModules,
        InterConfigSystem $confAdmin,
        InterPermission $interPermissions)
    {
        $this->middleware('auth:admin');

        $this->confAdmin        = $confAdmin;
        $this->interModel       = $interModel;
        $this->interConfig      = $interConfig;
        $this->interModules     = $interModules;
        $this->interPermissions = $interPermissions;
        // Pagar config da imagem do admin
        $this->interConfig      = $interConfig->setId(1);

    }


    /**
     * Perfil do usuário. admin
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    protected function profile($id)
    {
        if( Gate::denies("{$this->ability}-view") ) {
            return view("backend.erros.message-401");
        }

        $title = 'Perfil do Usuário';
        $data  = $this->interModel->setId(numLetter($id));

        return view("{$this->view}.profile", compact('data', 'title'));    
    }


    /**
     * Perfil do usuário. admin  excluidos
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    protected function profileExcluded($id)
    {
        if( Gate::denies("{$this->ability}-view") ) {
            return view("backend.erros.message-401");
        }

        $title = 'Perfil do Usuário';
        $data  = $this->interModel->setIdExcluded(numLetter($id));

        return view("{$this->view}.profile", compact('data', 'title'));
    }

    /**
     * Acessos do usuário.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    protected function accessView($id)
    {

        if( Gate::denies("{$this->ability}-access") ) {
            return view("backend.erros.message-401");
        }

        $data   = $this->interModel->setId(numLetter($id));
        $title  = 'Acessos do Usuário';
        $lists  = listAccessTxt(numLetter($id));
        $access = $data->accesses;

        $files  = array();
        
        foreach ($lists as $key => $value) {
            $str[$key]['str']    = substr($value, -14);
            $files[$key]['path'] = $value;
            $files[$key]['date'] = substr($str[$key]['str'], 0, 10);
        }

        return view("{$this->view}.accesses", compact('id','data','title','files','access'));    
    }


    /**
     * Acessos do usuário excluido.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    protected function accessViewExcluded($id)
    {

        if( Gate::denies("{$this->ability}-access") ) {
            return view("backend.erros.message-401");
        }

        $data   = $this->interModel->setIdExcluded(numLetter($id));
        $title  = 'Acessos do Usuário';
        $lists  = listAccessTxt(numLetter($id));
        $access = $data->accesses;

        $files  = array();

        foreach ($lists as $key => $value) {
            $str[$key]['str']    = substr($value, -14);
            $files[$key]['path'] = $value;
            $files[$key]['date'] = substr($str[$key]['str'], 0, 10);
        }

        return view("{$this->view}.accesses", compact('id','data','title','files','access'));
    }


    /**
     * Acessos do usuário excluido.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    protected function photoAdminExcluded($id)
    {
        if (Gate::denies("{$this->ability}-view")) {
            return view("backend.erros.message-401");
        }

        $width    = $this->interConfig->width_photo;
        $height   = $this->interConfig->height_photo;
        $path     = $this->interConfig->path.$width.'x'.$height.'/';
        $disk     = storage_path('app/public/');
        $photoUrl = 'storage/'.$path;

        $upload = array(
            'name' => 'image',
            'type' => 'photo',
            'disk' => $disk,
            'width' => $width,
            'height' => $height,
            'path' => $path,
            'photo_url' => $photoUrl,
            "btn" => array(
                "create" => "Adicionar",
                "edit" => "Editar",
                "status" => "Alterar Status",
                "delete" => "Excluir Imagem"
            )
        );

        $admin = $this->interModel->setIdExcluded(numLetter($id));
        $data  = $admin->photo;
        $count = count($admin->photo);
        $title = 'Foto do Usuário';

        return view("{$this->view}.images.excludeds", compact('id', 'data', 'title', 'upload', 'count'));

    }





    /**
     * Acessos do usuário.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    protected function accessActions(Request $request, $id)
    {
        if( Gate::denies("{$this->ability}-access") ) {
            return view("backend.erros.message-401");
        }

        $id     = numLetter($id);
        $name   = $request['user'];
        $path   = $request['path'];
        $action = $request['ac'];

        if ($action == 'open') {

            $open = actionsTxt($action, $path, $name, $id);

        } else {            

            if ($action == 'delete') {

                if( Gate::denies("{$this->ability}-access-delete") ) {
                    return view("backend.erros.message-401");
                }

                $out = actionsTxt($action, $path, $name, $id);

            } else {

                if( Gate::denies("{$this->ability}-access-delete-all") ) {
                    return view("backend.erros.message-401");
                }

                $path = 'Accesses/'.$id;  
                $out = actionsTxt($action, $path, $name, $id);

            }

            return response()->json($out);
        }

    }



    /**
     * Table Permissões do usuário.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    protected function getModules($id, $type)
    {
        $admin   = $this->interModel->setId(numLetter($id));
        $modules = $this->interModules->getType($type);

        switch ($type) {
            case 'C':
                $title = "Modulos de Configurações";
                break;
            case 'A':
                $title = "Modulos do Sistema";
                break;
        }

        return view("{$this->view}.modules", compact('admin','modules','title'));
    }


    /**
     * Table Permissões do usuário.
     *
     * @param  int  $id usuário
     * @return \Illuminate\Http\Response
     */
    protected function permissions($id, $idmod)
    {
        $title  = 'Permissões do Usuário';
        $data   = $this->interModel->setId(numLetter($id));
        $mData  = $this->interModules->setId($idmod);
        $fields = $mData->permissions()->distinct('module_id')->get();
        $active = $this->interPermissions->getUsers($idmod, numLetter($id));

        $array[0] = 'no-permission';
        if (count($active) > 0) {
            foreach ($active as $i => $value) {
                $array[$i] = $value->name;
            }
        }

        foreach ($fields as $k => $v) {
            $checks[$k]['id']        = $v->id;
            $checks[$k]['name']      = $v->name;
            $checks[$k]['label']     = $v->label;
            $checks[$k]['module_id'] = $v->module_id;
            if (strInArray($checks[$k]['name'], $array)) {
                $checks[$k]['value']     = 1;
                $checks[$k]['checked']   = ' checked';
            } else {
                $checks[$k]['value']     = 0;
                $checks[$k]['checked']   = '';
            }
        }



        return view("{$this->view}.permissions", compact('title', 'id','checks'));
    }

    /**
     * Mudar permissão do usuário.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    protected function updatePermission(
        Request $request, $id, 
        InterConfigPermission $permission,
        InterConfigProfile $profile)
    {


        $user = $this->interModel->setId(numLetter($id));
        $perm = $permission->setId($request['id']);
        $mode = $this->interModules->setId($perm->module_id);
        $prof = $profile->getFild('name', $user->profile);


        $update = $this->interPermissions->updatePermiison(
                        $request['ac'], 
                        $prof->id, 
                        $user, 
                        $perm,
                        $mode
                  );

        if ($update) {
            $success = true;
            $message = $update;
        } else {
            $success = false;
            $message = 'Houve um problema no servidor.';
        }

        $out = array(
            "success" => $success,
            "message" => $message
        );

        return response()->json($out);
    }


    protected function getPhoto($id)
    {
        if (Gate::denies("{$this->ability}-view")) {
            return view("backend.erros.message-401");
        }


        $title = 'Foto do Usuário';
        $data  = $this->interModel->setId(numLetter($id));

        dd($data);


        $upload = array(
            'name' => 'image',
            'type' => 'banner',
            'width' => 300,
            'height' => 300,
            'path' => url('storage/imagens/users/'),
            "btn" => array(
                "create" => "Adicionar",
                "edit" => "Editar",
                "status" => "Alterar Status",
                "delete" => "Excluir Imagem"
            )
        );

        return view("{$this->view}.photo", compact('id', 'data', 'title', 'upload'));


    }
    
}
