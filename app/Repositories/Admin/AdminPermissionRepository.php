<?php

namespace AVDPainel\Repositories\Admin;


use AVDPainel\Models\Admin\AdminPermission as Model;
use AVDPainel\Interfaces\Admin\AdminPermissionInterface;


class AdminPermissionRepository implements AdminPermissionInterface
{

    public $model;

    /**
     * Create construct.
     *
     * @return void
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
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
     * Display a listing of the resource.
     *
     * @return array
     */
    public function getAll($request)
    {
        $columns = array( 
            0 => 'name',
            1 => 'profile',
            2 => 'status',
            3 => 'email',
            4 => 'commission',
            5 => 'percent',            
            6 => 'created_at',
            7 => 'updated_at',
            8 => 'txt_status',
            9 => 'phone',
            10 => 'id',

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
                            ->where('profile','LIKE',"%{$search}%")
                            ->where('email','LIKE',"%{$search}%")
                            ->orWhere('phone', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = $this->model->where('name','LIKE',"%{$search}%")
                            ->where('profile','LIKE',"%{$search}%")
                            ->where('email','LIKE',"%{$search}%")
                            ->orWhere('phone', 'LIKE',"%{$search}%")
                             ->count();
        }

        $data  = array();
        if(!empty($query))
        {
            foreach ($query as $val){
                if ($val->profile != 'Master') {

                    ($val->status == "Ativo" ? $cor = 'green' : $cor = 'red');
                    $onclick = "statusUser('".route('user.status', ['id' => $val->id])."', '$val->name')";
                    
                    $nData['name']        = $val->name;
                    $nData['profile']     = $val->profile;
                    $nData['status']      = '<button onclick="'.$onclick.'" class="button icon-tick '.$cor.'-gradient compact">'.$val->status.'</button>';
                    $nData['email']       = $val->email;
                    $nData['commission']  = $val->commission;
                    $nData['percent']     = $val->percent;
                    $nData['created_at']  = date('j M Y h:i:s',strtotime($val->created_at));
                    $nData['updated_at']  = date('j M Y h:i:s',strtotime($val->updated_at));
                    $nData['txt_status']  = '<small class="tag '.$cor.'-bg">'.$val->status.'</small>';
                    $nData['phone']       = $val->phone;
                    $nData['id']          = numLetter($val->id, 'letter');
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
        $data = $this->model->where($fild, $name)->get();

        return $data;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return array
     */
    public function set($id)
    {
        return $this->model->find($id);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  array $input
     * @return boolean true or false
     */
    public function create($input)
    {
        $data = $this->model->create($input);
        if ($data) {
            return $data;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param  array $input
     * @return boolean true or false
     */
    public function update($input, $id)
    {
        $data   = $this->set($id);
        $update = $data->update($input);
        if ($update) {
            return true;
        }

        return false;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return boolean true or false
     */
    public function delete($id)
    {
        $data   = $this->model->find($id);
        $delete = $data->delete();
        if ($delete) {
            return true;
        }

        return false;
    }

    /**
     * Remove storage specific features.
     *
     * @param  int  $id
     * @return boolean true or false
     */
    public function deleteAdmin($id)
    {
        if ( $this->model->where('admin_id', $id)->delete() ) {
            return true;
        }

        return false;
    }


    /**
     * Obter o valor correspondente ao campo indicado.
     *
     * @param  int $mod
     * @param  int $user
     * @return array
     */
    public function getUsers($mod, $user)
    {
        return $this->model->where(["module_id" => $mod])->get();
    }

    /**
     * Alterar ou Adicionar a permissão.
     *
     * @param  string  $action
     * @param  int   $profile id
     * @param  int   $admin id
     * @param  array $perm
     * @return boolean true or false
     */
    public function updatePermiison($action, $profile, $user, $perm, $mode)
    {

        $data = $this->model->where([
            "module_id" => $mode->id,
            "admin_id"  => $user->id,
            "name"      => $perm->name
        ])->first();

        if ($action == 'remove') {

            if ($data) {
                if ( $data->delete() ) {
                    generateAccessesTxt(
                        date('H:i:s').utf8_decode(
                        ' Desabilitou o Usuário:'.$user->name.
                        ' - '.$perm->label.
                        ':'.$mode->name)
                    );
                    return  "A permissão {$perm->label} foi desabilitada.";
                } else {
                    return  "Não foi possível desabilitar a permissão {$perm->label}.";
                }
            } else {

                return "A permissão {$perm->label}, já se encontar habilitada.";
            }

        } 

        if ( empty($data) && $action == 'insert') {
            $input = [
                "module_id" =>$mode->id,
                "admin_id" => $user->id,
                "profile_id" => $profile,
                "permission_id" => $perm->id,
                "name" => $perm->name,
                "label" => $perm->label,
            ];

            if ( $this->model->create($input) ) {
                generateAccessesTxt(
                    date('H:i:s').utf8_decode(
                    ' Habilitou o Usuário:'.$user->name.
                    ' - '.$perm->label.
                    ':'.$mode->name)
                );

                return "A permissão {$perm->label} foi habilitada.";
            } else {
                return "Não foi habilitar a permissão {$perm->label}";
            }
        } else {
            return "A permissão {$perm->label}, já se encontar habilitada.";
        }


    }


}