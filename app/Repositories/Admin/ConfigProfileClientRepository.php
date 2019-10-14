<?php

namespace AVDPainel\Repositories\Admin;


use AVDPainel\Models\Admin\ConfigProfileClient as Model;
use AVDPainel\Interfaces\Admin\ConfigProfileClientInterface;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Validation\ValidatesRequests;

class ConfigProfileClientRepository implements ConfigProfileClientInterface
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
        $data  = $this->model->where('active', constLang('active_true'))->orderBy('order')->get();
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
            1 => 'name',
            2 => 'percent_card',
            3 => 'percent_cash',
            4 => 'sum',
            5 => 'active',
            6 => 'actions',
            7 => 'updated_at',
            8 => 'created_at',
            9 => 'id'

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
                if ($val->profile != 'Normal') {
                    if ($val->sum == '+') {
                        $sum = '<span class="icon-squared-plus blue-gradient icon-size2" title="Mais"></span>';
                    } else {
                        $sum = '<span class="icon-squared-minus red-gradient icon-size2" title="Menos"></span>';
                    }

                    ($val->active == 'Ativo' ? $color = 'blue' : $color = 'red');

                    $edit   = "abreModal('Editar {$val->name}', '".route('customers-perfil.edit', ['id' => $val->id])."', 'profile-clients', 2, 'true', 380, 260)";
                    $delete = "deleteProfileClient('".route('customers-perfil.destroy', ['id' => $val->id])."', '{$val->name}')";

                    $nData['order']        = $val->order;
                    $nData['name']         = $val->name;
                    $nData['percent_card'] = round($val->percent_card, 2). '%';
                    $nData['percent_cash'] = round($val->percent_cash, 2). '%';
                    $nData['sum']          = $sum;
                    $nData['active']       = '<small class="tag '.$color.'-bg">'.$val->active.'</small>';
                    $nData['actions']      = '<span class="button-group">';
                    if (Gate::allows('config-percent-delete')) {
                        $nData['actions'] .= '<button onclick="'.$delete.'" class="button icon-trash red-gradient compact"></button>';
                    }
                    if (Gate::allows('config-profile-client-update')) {
                        $nData['actions'] .= '<button onclick="'.$edit.'" class="button icon-pencil compact"></button>';
                    }
                    $nData['actions']     .= '</span>';
                    $nData['updated_at']   = date('j M Y h:i:s',strtotime($val->updated_at));
                    $nData['created_at']   = date('j M Y h:i:s',strtotime($val->created_at));
                    $nData['id']           = $val->id;
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
     * List profile/id/status/active
     *
     * @return array
     */
    public function pluck()
    {
        return $this->model->orderBy('order')->where('active', constLang('active_true'))->pluck('name','id');
    }


    public function setDefault()
    {
        $data = $this->model->where('default', 1)->first();

        return $data;

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
        // if < 10 add 0 in front
        $count = strlen($input['order']);
        if ($count == 1) {
            $input['order'] = '0'.$input['order'];
        }

        $data = $this->model->create($input);

        if ($data) {
            generateAccessesTxt(
                date('H:i:s').utf8_decode(
                ' Adicionou o perfil do Cliente:'.$data->name.
                ' Parcelado:'.$data->percent_card.
                '% À Vísta:'.$data->percent_cash.
                '%, Ordem:'.$data->order.
                ', Calculo para:'.$data->sum.
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
        $data         = $this->model->find($id);
        $sum          = $data->sum;
        $order        = $data->order;
        $active       = $data->active;
        $profile      = $data->name;
        $percent_card = $data->percent_card;
        $percent_cash = $data->percent_cash;

        $update = $data->update($input);
        if ($update) {
            generateAccessesTxt(
                date('H:i:s').utf8_decode(
                ' Alterou o perfil do Cliente:'.$profile.
                ' Parcelado:'.$percent_card.
                '% À Vísta:'.$percent_cash.
                '%, Ordem:'.$order.
                ', Calculo para:'.$data->sum.
                ', Status:'.$active.
                ' - Para Parcelado:'.$input['percent_card'].
                '% À Vísta:'.$input['percent_cash'].
                '%, Ordem:'.$input['order'].
                ', Calculo para:'.$data->sum.
                ', Status:'.$input['active'])
            );
            return true;
        }

        return false;
    }

    /**
     * Não permitir remover o id 1 ( Necessário ter um como referencia)
     *
     * @param  int  $id
     * @return boolean true or false
     */
    public function delete($id)
    {
        if ($id != 1) {
            $data   = $this->model->find($id);
            $delete = $data->delete();
            if ($delete) {
                generateAccessesTxt(
                    date('H:i:s').utf8_decode(
                        ' Removeu o perfil do Cliente:'.$data->name.
                        ' Parcelado:'.$data->percent_card.
                        '% À Vísta:'.$data->percent_cash.
                        '%, Ordem:'.$data->order.
                        ', Calculo para:'.$data->sum.
                        ', Status:'.$data->active)
                );
                return true;
            }
        }


        return false;
    }


}