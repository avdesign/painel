<?php

namespace AVDPainel\Repositories\Admin;


use AVDPainel\Models\Admin\ConfigModule as Model;
use AVDPainel\Interfaces\Admin\ConfigModuleInterface;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Validation\ValidatesRequests;

class ConfigModuleRepository implements ConfigModuleInterface
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
            0 => 'name',
            1 => 'type',
            2 => 'order', 
            3 => 'label',
            4 => 'status',
            5 => 'details_url',
            6 => 'created_at',
            7 => 'id',

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
                            ->where('type','LIKE',"%{$search}%")
                            ->orWhere('label', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = $this->model->where('name','LIKE',"%{$search}%")
                             ->where('type','LIKE',"%{$search}%")
                             ->orWhere('label', 'LIKE',"%{$search}%")
                             ->count();
        }

        $data  = array();
        if(!empty($query))
        {
            foreach ($query as $val){

                $edit   = "abreModal('Editar {$val->name}', '".route('modules.edit', ['id' => $val->id])."', 'metodo', 2, 'true', 400, 220)";
                $delete = "deleteModule('".route('modules.destroy', ['id' => $val->id])."', '{$val->name}')";

                $nData['name']        = $val->name;
                $nData['type']        = $val->type;
                $nData['order']       = $val->order;
                $nData['label']       = $val->label;
                $nData['actions']     = '<span class="button-group">';
                if (Gate::allows('config-module-delete')) {
                    $nData['actions'].= '<button onclick="'.$delete.'" class="button icon-trash red-gradient compact"></button>';
                }
                if (Gate::allows('config-module-update')) {
                    $nData['actions']       .= '<button onclick="'.$edit.'" class="button icon-pencil compact"></button>';
                }
                
                $nData['actions']    .= '</span>';
                $nData['details_url'] = route('module.permissions.show', ['id' => $val->id]);
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
     * Retorna os modulos pelo type.
     *
     * @return array
     */
    public function getType($type)
    {
        return $this->model->where('type', $type)->orderBy('order')->get();
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
     * Lists the specified resource.
     *
     * @param  string  $name
     * @param  int  $id
     * @return array
     */
    public function pluck()
    {
        return $this->model->pluck('name','id');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  array $input
     * @return boolean true or false
     */
    public function create($input)
    {
        // if < 10 add 0 in front
        $count = strlen($input['order']);
        if ($count == 1) {
            $input['order'] = '0'.$input['order'];
        }

        $data = $this->model->create($input);
        if ($data) {
            generateAccessesTxt(
                date('H:i:s').utf8_decode(
                ' Adicionou o modulo: '.$data->name.
                ', Tipo: '.$data->type.
                ', Ordem: '.$data->order.
                ', Desc: '.$data->label)
            );

            return $data;
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
    public function update($input, $id)
    {

        $data  = $this->model->find($id);
        $name  = $data->name;
        $type  = $data->type;
        $label = $data->label;
        $order = $data->order;

        $update = $data->update($input);
        if ($update) {
            generateAccessesTxt(
                date('H:i:s').utf8_decode(
                ' Alterou o Modulo: '.$name.
                ', Tipo: '.$type.
                ', Ordem: '.$order.
                ', Desc: '.$label.
                ' Para Modulo: '.$input['name'].
                ', Tipo: '.$input['type'].
                ', Ordem: '.$input['order'].
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
                ' Excluiu o modulo: '.$data->name.
                ', Tipo: '.$data->type.
                ', Ordem: '.$data->order.
                ', Desc: '.$data->label)
            );
            return true;
        }

        return false;
    }


  /**
     * Lista os modules para verificar se o usuário tem permissão.
     *
     * @param  array  $request
     * @param  string  $type (C: Configurações, A: Sistema Adimin, R: Reservados) 
     * @param  int  $id user (numLetter)
     * @return \Illuminate\Http\Response
     */
    public function typeModules($request, $id, $type)
    {

        //sleep(15);
        $columns = array( 
            0 => 'order',
            1 => 'name',
            2 => 'label',
            3 => 'details_url',
            4 => 'created_at',
            5 => 'updated_at',
            6 => 'id'

        );
  
        $totalData = $this->model->where('type', $type)->count();
            
        $totalFiltered = $totalData; 

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir   = $request->input('order.0.dir');
            
        if (empty($request->input('search.value'))) {            
            $query = $this->model->where('type', $type)
                        ->offset($start) ->limit($limit)
                        ->orderBy($order,$dir)                        
                        ->get();
        } else {
            $search = $request->input('search.value'); 

            $query =  $this->model->where('type', $type)
                            ->where('name','LIKE',"%{$search}%")
                            ->orWhere('label', 'LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = $this->model->where('type', $type)
                            ->where('name','LIKE',"%{$search}%")
                            ->orWhere('label', 'LIKE',"%{$search}%")
                            ->count();
        }

        $data  = array();
        if(!empty($query))
        {
            foreach ($query as $val){

                $nData['DT_RowId']    = 'row_'.$val->id;
                $nData['order']       = $val->order;
                $nData['name']        = $val->name;
                $nData['label']       = $val->label;
                $nData['permiss_url'] = route('admin.permissions.data', ['id' => $id, 'idmod' => $val->id]);
                $nData['created_at']  = date('j M Y h:i:s',strtotime($val->created_at));
                $nData['updated_at']  = date('j M Y h:i:s',strtotime($val->updated_at));
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

            
        return response()->json($out);
    }    

}