<?php

namespace AVDPainel\Repositories\Admin;


use AVDPainel\Models\Admin\ConfigPercent as Model;
use AVDPainel\Interfaces\Admin\ConfigPercentInterface;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Validation\ValidatesRequests;

class ConfigPercentRepository implements ConfigPercentInterface
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
            1 => 'percent',
            2 => 'active',
            3 => 'actions',
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


            $query =  $this->model->where('percent','LIKE',"%{$search}%")
                            ->offset($start)
                            ->limit($limit)
                            ->orderBy($order,$dir)
                            ->get();

            $totalFiltered = $this->model->where('percent','LIKE',"%{$search}%")
                             ->count();
        }

        $data  = array();
        if(!empty($query))
        {
            foreach ($query as $val){

                ($val->status == 'Ativo' ? $color = 'blue' : $color = 'red');

                $edit   = "abreModal('Editar {$val->percent}', '".route('percents.edit', ['id' => $val->id])."', 'percent', 2, 'true', 380, 200)";
                $delete = "deletePercent('".route('percents.destroy', ['id' => $val->id])."', '{$val->percent}')";

                $nData['order']        = $val->order;
                $nData['percent']      = $val->percent. '%';
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
     * Lista só com o percent e o id.
     *
     * @return array
     */
    public function pluck()
    {
        return $this->model->orderBy('order')->where('active', constLang('active_true'))->pluck('percent','id');
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
                ' Adicionou a porcentagem:'.$data->percent.
                '%, Ordem:'.$data->order.
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
        $data    = $this->model->find($id);
        $order   = $data->order;
        $status  = $data->active;
        $percent = $data->percent;

        $update = $data->update($input);
        if ($update) {
            generateAccessesTxt(
                date('H:i:s').utf8_decode(
                ' Alterou a porcentagem:'.$percent.
                '%, Ordem:'.$order.
                ', Status:'.$status.
                ' - Para:'.$input['percent'].
                '%, Ordem:'.$input['order'].
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
                ' Removeu a porcentagem:'.$data->percent.
                '%, Ordem:'.$data->order.
                ', Status:'.$data->active)
            );
            return true;
        }

        return false;
    }


}