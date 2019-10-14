<?php

namespace AVDPainel\Repositories\Admin;


use AVDPainel\Models\Admin\Admin as Model;
use AVDPainel\Interfaces\Admin\AdminInterface;


class AdminRepository implements AdminInterface
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
        return $this->model->get();
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
            2 => 'active',
            3 => 'phone',
            4 => 'commission',
            5 => 'percent',            
            6 => 'created_at',
            7 => 'updated_at',
            8 => 'txt_status',
            9 => 'email',
            10 => 'id',

        );
  
        $totalData = $this->model->count();
            
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir   = $request->input('order.0.dir');
            
        if (empty($request->input('search.value'))) {            
            $query = $this->model->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();
        } else {
            $search = $request->input('search.value'); 

            $query =  $this->model->where('name','LIKE',"%{$search}%")
                            ->orWhere('profile','LIKE',"%{$search}%")
                            ->orWhere('email','LIKE',"%{$search}%")
                            ->orWhere('phone', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = $this->model->where('name','LIKE',"%{$search}%")
                            ->orWhere('profile','LIKE',"%{$search}%")
                            ->orWhere('email','LIKE',"%{$search}%")
                            ->orWhere('phone', 'LIKE',"%{$search}%")
                             ->count();
        }

        $data  = array();
        if(!empty($query))
        {
            foreach ($query as $val){
                if ($val->profile != 'Master') {

                    ($val->active == constLang('active_true') ? $cor = 'green' : $cor = 'red');
                    
                    $nData['name']        = $val->name;
                    $nData['profile']     = $val->profile;
                    $nData['active']      = '<small class="tag '.$cor.'-bg">'.$val->active.'</small>';
                    $nData['phone']       = $val->phone;
                    $nData['commission']  = $val->commission;
                    $nData['percent']     = $val->percent;
                    $nData['created_at']  = date('j M Y h:i:s',strtotime($val->created_at));
                    $nData['updated_at']  = date('j M Y h:i:s',strtotime($val->updated_at));
                    $nData['txt_status']  = '<small class="tag '.$cor.'-bg">'.$val->active.'</small>';
                    $nData['email']       = $val->email;
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

    /**
     * @return mixed
     */
    public function pluck()
    {
        return $this->model->pluck('name','id');
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return array
     */
    public function setId($id)
    {        
        return $this->model->find($id);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return array
     */
    public function setIdExcluded($id)
    {
        return $this->model->onlyTrashed()->find($id);
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
            generateAccessesTxt(
                date('H:i:s').utf8_decode(
                ' Adicionou o usuário: '.$data->name.
                ', Perfil: '.$data->profile.
                ', Email: '.$data->email)
            );

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
        $data   = $this->setId($id);
        $update = $data->update($input);
        if ($update) {
            generateAccessesTxt(
                date('H:i:s').utf8_decode(
                ' Alterou o usuário: '.$data->name.
                ', Perfil: '.$data->profile.
                ', Email: '.$data->email)
            );

            return true;
        }

        return false;
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @param  array $input
     * @return boolean true or false
     */
    public function updateProfile($input, $id)
    {
        $data   = $this->setId($id);
        $update = $data->update($input);
        if ($update) {
            generateAccessesTxt(
                date('H:i:s').utf8_decode(
                ' Alterou seu próprio perfil, Nome:'.$data->name.
                ', Email:'.$data->email.
                ', Telefone:'.$data->phone)
            );

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
        $data   = $this->setId($id);
        $delete = $data->delete();
        if ($delete) {
            generateAccessesTxt(
                date('H:i:s').utf8_decode(
                ' Excluiu o usuário: '.$data->name.
                ', Perfil: '.$data->profile.
                ', Email: '.$data->email)
            );

            return true;
        }

        return false;
    }


    /**
     * Exclui os usuários com este perfil.
     *
     * @param  string  $name
     * @return void
     */
    public function deleteProfile($name)
    {
        $users_profile = $this->model->where('profile', $name)->get();
        $excluded='';
        if (count($users_profile)) {

            foreach ($users_profile as $user) {
                $this->model->find($user->id)->delete();
                $excluded .= $user->name.',';
            }
            
            generateAccessesTxt(
                date('H:i:s').utf8_decode(
                ' Excluiu '.$excluded.' com o Perfil:'.$name)
            );
        }
    }



    /**
     * Table users excluded.
     *
     * @return json
     */
    public function excluded($request)
    {
        $columns = array( 
            0 => 'name',
            1 => 'profile',
            2 => 'active',
            3 => 'phone',
            4 => 'commission',
            5 => 'percent',            
            6 => 'created_at',
            7 => 'updated_at',
            8 => 'txt_status',
            9 => 'email',
            10 => 'id'

        );
  
        $totalData = $this->model->onlyTrashed()->count();
            
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir   = $request->input('order.0.dir');
            
        if (empty($request->input('search.value'))) {            
            $query = $this->model->onlyTrashed()->offset($start) ->limit($limit) ->orderBy($order,$dir)
                         ->get();
        } else {
            $search = $request->input('search.value'); 

            $query =  $this->model->onlyTrashed()->where('name','LIKE',"%{$search}%")
                            ->where('profile','LIKE',"%{$search}%")
                            ->where('email','LIKE',"%{$search}%")
                            ->orWhere('phone', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = $this->model->onlyTrashed()->where('name','LIKE',"%{$search}%")
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

                    ($val->active == constLang('active_true') ? $cor = 'green' : $cor = 'red');
                    
                    $nData['name']        = $val->name;
                    $nData['profile']     = $val->profile;
                    $nData['active']      = '<small class="tag '.$cor.'-bg">'.$val->active.'</small>';
                    $nData['phone']       = $val->phone;
                    $nData['commission']  = $val->commission;
                    $nData['percent']     = $val->percent;
                    $nData['created_at']  = date('j M Y h:i:s',strtotime($val->created_at));
                    $nData['updated_at']  = date('j M Y h:i:s',strtotime($val->updated_at));
                    $nData['txt_status']  = '<small class="tag '.$cor.'-bg">'.$val->active.'</small>';
                    $nData['email']       = $val->email;
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

    /**
     * Reactivate user.
     *
     * @param  int  id
     * @return boolean true or false
     */
    public function reactivate($id)
    {
        $data = $this->model->withTrashed()->find($id);
        if ( $data->restore() ){
            generateAccessesTxt(
                date('H:i:s').utf8_decode(
                ' Reativou o usuário: '.$data->name.
                ', Perfil: '.$data->profile.
                ', Email: '.$data->email)
            );
            return true;
        }

         return false;    
    }

    

}