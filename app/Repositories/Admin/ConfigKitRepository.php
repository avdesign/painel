<?php

namespace AVDPainel\Repositories\Admin;


use AVDPainel\Models\Admin\ConfigKit as Model;
use AVDPainel\Interfaces\Admin\ConfigKitInterface;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Validation\ValidatesRequests;

class ConfigKitRepository implements ConfigKitInterface
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
     * Obter totos os registros.
     *
     * @return array
     */
    public function getAll($request)
    {
        $columns = array( 
            0 => 'order',
            2 => 'name',
            3 => 'active',
            4 => 'actions',
            5 => 'updated_at',
            6 => 'created_at',
            7 => 'id'

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
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = $this->model->where('name','LIKE',"%{$search}%")
                             ->count();
        }

        $data  = array();
        if(!empty($query))
        {
            foreach ($query as $val){

                ($val->active == constLang('active_true') ? $color = 'blue' : $color = 'red');

                $edit   = "abreModal('Editar {$val->name}', '".route('kits.edit', ['id' => $val->id])."', 'kits', 2, 'true', 400, 220)";
                $delete = "deleteKit('".route('kits.destroy', ['id' => $val->id])."', '{$val->name}')";

                $nData['order']        = $val->order;
                $nData['name']         = $val->name;
                $nData['active']       = '<small class="tag '.$color.'-bg">'.$val->active.'</small>';
                $nData['actions']      = '<span class="button-group">';
                if (Gate::allows('config-percent-delete')) {
                    $nData['actions'] .= '<button onclick="'.$delete.'" class="button icon-trash red-gradient compact"></button>';
                }
                if (Gate::allows('config-percent-update')) {
                    $nData['actions'] .= '<button onclick="'.$edit.'" class="button icon-pencil compact"></button>';
                }
                $nData['actions']     .= '</span>';
                $nData['updated_at']   = date('j M Y h:i:s',strtotime($val->updated_at));
                $nData['created_at']   = date('j M Y h:i:s',strtotime($val->created_at));
                $nData['id']           = $val->id;
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
     * Lista só com o name e o unit.
     *
     * @return array
     */
    public function pluck()
    {
        return $this->model->orderBy('order')->where('active', constLang('active_true'))->pluck('name','name');
    }



    /**
     * Obter o valor correspondente ao campo indicado.
     *
     * @param  string  $filde
     * @return int or string $id
     */
    public function getFilde($filde, $name)
    {
        
        $data = $this->model->where($filde, $name)->first();

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
        // if < 10 add 0 in front
        $count = strlen($input['order']);
        if ($count == 1) {
            $input['order'] = '0'.$input['order'];
        }

        $data = $this->model->create($input);

        if ($data) {
            generateAccessesTxt(
                date('H:i:s').utf8_decode(
                ' Adicionou o kit:'.$data->name.
                ', Ordem:'.$data->order.
                ', Status:'.$data->active)
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
        $data   = $this->model->find($id);
        $unit   = $data->unit;
        $name   = $data->name;
        $order  = $data->order;
        $active = $data->active;

        $update = $data->update($input);
        if ($update) {
            generateAccessesTxt(
                date('H:i:s').utf8_decode(
                ' Alterou o kit:'.$name.
                ', Ordem:'.$order.
                ', Status:'.$active.
                ' - Para:'.$input['name'].
                ', Ordem:'.$input['order'].
                ', Status:'.$input['active'])
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
                ' Removeu o kit:'.$data->name.
                ', Ordem:'.$data->order.
                ', Status:'.$data->active)
            );
            return true;
        }

        return false;
    }


}