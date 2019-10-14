<?php

namespace AVDPainel\Repositories\Admin;


use AVDPainel\Models\Admin\ConfigProfile as Model;
use AVDPainel\Interfaces\Admin\ConfigProfileInterface;
use AVDPainel\Interfaces\Admin\AdminInterface;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Validation\ValidatesRequests;


class ConfigProfileRepository implements ConfigProfileInterface

{
    use ValidatesRequests;
    
    public $model;
    public $users;

    /**
     * Create construct.
     *
     * @return void
     */
    public function __construct(
        Model $model,
        AdminInterface $users)
    {
        $this->model = $model;
        $this->users = $users;
    }

    /**
     * ValidatesRequests
     *
     * @param  array $input
     * @param  array $messages
     * @return array
     */
    public function rules($input, $messages, $id='')
    {
        $this->validate($input, $this->model->rules($id), $messages);
    }

    /**
     * Init Model
     *
     * @return array
     */
    public function get()
    {
        $data  = $this->model->get();
        return $data;    
    }


    /**
     * Obter totos os registros.
     *
     * @return array
     */
    public function getAll($request)
    {
        $columns = array( 
            0 => 'name',
            1 => 'label',
            2 => 'actions',
            3 => 'details_url',
            4 => 'updated_at',
            5 => 'created_at',
            6 => 'id'

        );
  
        $totalData = $this->model->count();
            
        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir   = $request->input('order.0.dir');
            
        if (empty($request->input('search.value'))) {            
            $query = $this->model->offset($start) ->limit($limit) ->orderBy($order,$dir)
                         ->get();
        } else {
            $search = $request->input('search.value'); 


            $query =  $this->model->where('name','LIKE',"%{$search}%")
                            ->where('label','LIKE',"%{$search}%")
                            ->orWhere('updated_at', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = $this->model->where('name','LIKE',"%{$search}%")
                            ->where('label','LIKE',"%{$search}%")
                            ->orWhere('updated_at', 'LIKE',"%{$search}%")
                             ->orWhere('label', 'LIKE',"%{$search}%")
                             ->count();
        }

        $data  = array();
        if(!empty($query))
        {
            foreach ($query as $val){
                if ($val->name != 'Master') {

                    $edit   = "abreModal('Editar {$val->name}', '".route('profiles.edit', ['id' => $val->id])."', 'profiles', 2, 'true', 400, 220)";
                    $delete = "deleteProfile('".route('profiles.destroy', ['id' => $val->id])."', '{$val->name}')";

                    $nData['name']        = $val->name;
                    $nData['label']       = $val->label;
                    $nData['actions']     = '<span class="button-group">';
                    if (Gate::allows('config-profile-delete')) {
                        $nData['actions'] .= '<button onclick="'.$delete.'" class="button icon-trash red-gradient compact"></button>';
                    }
                    if (Gate::allows('config-profile-update')) {
                        $nData['actions'] .= '<button onclick="'.$edit.'" class="button icon-pencil compact"></button>';
                    }
                    $nData['actions']    .= '</span>';
                    $nData['details_url'] = route('profile.users.show', ['id' => $val->id]);
                    $nData['updated_at']  = date('j M Y h:i:s',strtotime($val->updated_at));
                    $nData['created_at']  = date('j M Y h:i:s',strtotime($val->created_at));
                    $nData['id']          = $val->id;
                    $data[] = $nData;
                }
            }
        }
          
        $out = array(
            "draw" => intval($request->input('draw')),  
            "recordsTotal" => intval($totalData),  
            "recordsFiltered" => intval($totalFiltered), 
            "data" => $data
        );

        return $out;
    }


    /**
     * Lista só com o name e o id.
     *
     * @return array
     */
    public function pluck()
    {
        return $this->model->pluck('name','id');
    }



    /**
     * Obter o valor correspondente ao campo indicado.
     *
     * @param  string  $filde
     * @return int or string $id
     */
    public function getFild($fild, $name)
    {
        
        $data = $this->model->where($fild, $name)->first();

        return $data;
    }
    

    /**
     * Instaciar um perfil
     *
     * @param  int  $id
     * @return array
     */
    public function setId($id)
    {
        return $this->model->find($id);
    }

    /**
     * Adicionar
     *
     * @param  array $input
     * @return boolean true or false
     */
    public function create($input)
    {

        $data = $this->model->create($input);
        if ($data) {
            generateAccessesTxt(
                date('H:i:s').utf8_decode(
                ' Adicionou o Perfil:'.$data->name.
                ', Desc:'.$data->label)
            );
            return $data;
        }
    }


    /**
     * Alterar
     *
     * @param  int  $id
     * @param  array $input
     * @return boolean true or false
     */
    public function update($input, $id)
    {
        $data  = $this->model->find($id);
        $name  = $data->name;
        $label = $data->label;

        $update = $data->update($input);
        if ($update) {
            generateAccessesTxt(
                date('H:i:s').utf8_decode(
                ' Alterou o Perfil:'.$name.
                ', Desc:'.$label.
                ' para Perfil:'.$data->name.
                ', Desc:'.$data->label)
            );
            return true;
        }

        return false;
    }

    /**
     * Remover
     *
     * @param  int  $id
     * @return boolean true or false
     */
    public function delete($id)
    {
        $data   = $this->model->find($id);
        $delete = $data->delete();
        if ($delete) {

            generateAccessesTxt(
                date('H:i:s').utf8_decode(
                ' Excluiu o Perfil:'.$data->name.
                ', Desc:'.$data->label)
            );

            // Excluir usuários com este perfil 
            $users_profile = $this->users->deleteProfile($data->name);

            return true;
        }

        return false;
    }


    /**
     * Adicionar users
     *
     * @param  int $id 
     * @param  array $input
     * @return boolean true or false
     */
    public function addUsers($input, $id)
    {
        $data = $this->model->find($id);
        foreach ($input as $k => $value) {
            $res[$k]   = explode("|", $value);
            $array[$k] = $res[$k][1];
            $codes[$k] = $res[$k][0];
        }

        $users = $data->users();
        $data->users()->attach($codes);

        (count($array) >= 2 ? $txt = 'os usuários' : $txt = 'o usuário');

        $names = '"'. implode('","', $array) .'"';

        if ($data->users()) {
            generateAccessesTxt(
                date('H:i:s').utf8_decode(' Adicionou '.$txt.
                    ': '.$names.
                    ' - Com o perfil de: "'.$data->name.'"')
            );
            return true;
        }
        return false;
    }

    /**
     * Remover o usuário
     *
     * @param  int  $id
     * @param  int  $id user
     * @return boolean true or false
     */
    public function removeUser($id, $iduser, $name)
    {
        $data   = $this->model->find($id);
        $delete = $data->users()->detach($iduser);

        if ($delete) {
            generateAccessesTxt(
                date('H:i:s').utf8_decode(
                    ' Excluiu o usuário "'.$name.
                    '" do perfil: "'.$data->name.'"')
            );
            return true;
        }

        return false;
    }
}