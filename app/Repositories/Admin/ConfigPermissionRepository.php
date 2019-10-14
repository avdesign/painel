<?php

namespace AVDPainel\Repositories\Admin;


use AVDPainel\Models\Admin\ConfigPermission as Model;
use AVDPainel\Interfaces\Admin\ConfigPermissionInterface;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Validation\ValidatesRequests;

class ConfigPermissionRepository implements ConfigPermissionInterface
{
    use ValidatesRequests;

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
     * Display a listing of the resource.
     *
     * @return array
     */
    public function getAll($request)
    {
        $columns = array( 
            0 => 'label',
            1 => 'name',
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
            $query = $this->model->with(array(
                'module' => function ($query) {
                    $query->orderBy('order');
                }
            ))
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();

        } else {
            $search = $request->input('search.value'); 

            $query =  $this->model->where('name','LIKE',"%{$search}%")
                ->orWhere('label', 'LIKE',"%{$search}%")->with(array(
                    'module' => function ($query) {
                        $query->orderBy('order');
                    }
                ))
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();

            $totalFiltered = $this->model->where('name','LIKE',"%{$search}%")
                             ->orWhere('label', 'LIKE',"%{$search}%")->with(array(
                                'module' => function ($query) {
                                    $query->orderBy('order');
                                }
                             ))
                             ->count();
        }

        $data  = array();
        if(!empty($query))
        {
            foreach ($query as $val){


                $edit   = "abreModal('Editar {$val->name}', '".route('permissions.edit', ['id' => $val->id])."', 'metodo', 2, 'true', 400, 220)";
                $delete = "deletePermission('".route('permissions.destroy', ['id' => $val->id])."', '{$val->name}')";

                $nData['label']       = $val->label;
                $nData['name']        = $val->module->name;
                $nData['actions']     = '<span class="button-group">';
                if (Gate::allows('config-permission-delete')) {
                    $nData['actions'] .= '<button onclick="'.$delete.'" class="button icon-trash red-gradient compact"></button>';
                }
                if (Gate::allows('config-permission-update')) {
                    $nData['actions'] .= '<button onclick="'.$edit.'" class="button icon-pencil compact"></button>';
                }
                $nData['actions']    .= '</span>';
                $nData['details_url'] = route('permission.profile.show', ['id' => $val->id]);
                $nData['updated_at']  = date('j M Y h:i:s',strtotime($val->updated_at));
                $nData['created_at']  = date('j M Y h:i:s',strtotime($val->created_at));
                $nData['id']          = $val->id;
                $data[] = $nData;
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
                ' Adicionou a Permissão: '.$data->name.
                ', Desc: '.$data->label)
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
        $data  = $this->model->find($id);
        $name  = $data->name;
        $label = $data->label;

        $update = $data->update($input);
        if ($update) {
            generateAccessesTxt(
                date('H:i:s').utf8_decode(
                ' Alterou a Permissão: '.$name.
                ', Desc: '.$label.
                ' Para Permissão: '.$input['name'].
                ', Desc: '.$input['label'])
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
        $data   = $this->model->find($id);
        $delete = $data->delete();
        if ($delete) {
            generateAccessesTxt(
                date('H:i:s').utf8_decode(
                ' Excluiu a Permissão: '.$data->name.
                ', Desc: '.$data->label)
            );
            return true;
        }

        return false;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  array $input
     * @return boolean true or false
     */
    public function addProfile($input, $id)
    {

        $data = $this->model->find($id);
        foreach ($input as $k => $value) {
            $res[$k]   = explode("|", $value);
            $array[$k] = $res[$k][1];
            $codes[$k] = $res[$k][0];
        }

        $data->profiles()->attach($codes);

        (count($array) >= 2 ? $txt = 'os perfis' : $txt = 'o perfil');

        $names = '"'. implode('","', $array) .'"';

        if ($data->profiles()) {
            generateAccessesTxt(
                date('H:i:s').utf8_decode(' Adicionou '.$txt.
                    ': '.$names.
                    ' - na permissão: "'.$data->name.'"')
            );
            return $data;
        }
    }    

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return boolean true or false
     */
    public function delProfile($id, $idpro, $name)
    {
        $data   = $this->model->find($id);
        $delete = $data->profiles()->detach($idpro);
        if ($delete) {
            generateAccessesTxt(
                date('H:i:s').utf8_decode(
                ' Excluiu o perfil '.$name.
                ', da permissão '.$data->name)
            );
            return true;
        }

        return false;
    }

}