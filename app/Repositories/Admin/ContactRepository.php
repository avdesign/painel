<?php

namespace AVDPainel\Repositories\Admin;


use AVDPainel\Models\Admin\Contact as Model;
use AVDPainel\Interfaces\Admin\ContactInterface;

use Illuminate\Foundation\Validation\ValidatesRequests;

class ContactRepository implements ContactInterface
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
        $data  = $this->model->orderBy('created_at', 'desc')->get();
        return $data;    
    }



    /**
     * Table: Keyword
     *
     * @return array
     */
    public function getAll($request)
    {
        $columns = array( 
            0  => 'created_at',
            1  => 'name',
            2  => 'subject',
            3  => 'message',
            4  => 'client',
            5  => 'send',
            6  => 'email',
            7  => 'phone',
            8  => 'cell',
            9  => 'city',
            10 => 'state',
            11 => 'zip_code',
            12 => 'ip',
            13 => 'id',


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
            if (strlen($search) >= 3) {
                $query = $this->model->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('message', 'LIKE', "%{$search}%")
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order, $dir)
                    ->get();

                $totalFiltered = $this->model->where('name', 'LIKE', "%{$search}%")
                    ->orWhere('email', 'LIKE', "%{$search}%")
                    ->orWhere('message', 'LIKE', "%{$search}%")
                    ->count();
            } else {
                $totalFiltered = [];
            }

        }

        $data  = array();
        if(!empty($query))
        {
            foreach ($query as $val){

                ($val->send == 1 ? $send = '<small class="tag blue-bg">Sim</small>' :
                    $send = '<small class="tag red-bg">Não</small>');
                ($val->client == 1 ? $client = '<small class="tag blue-bg">Sim</small>' :
                    $client = '<small class="tag red-bg">Não</small>');
                $icon_star = '';
                $icon_flag = '';
                $status    = '';
                if ($val->status == 1) {
                    $icon_star = 'orange';
                    $status    = '<span class="icon-star orange"></span>';
                }
                if ($val->status == 2) {
                    $icon_flag = 'red';
                    $status    = '<span class="icon-flag red"></span>';
                }

                $nData['created_at'] = $status.' '.date('d/m/Y H:i:s', strtotime($val->created_at));
                $nData['name']       = $val->name;
                $nData['subject']    = $val->subject;
                $nData['message']    = $val->message;
                $nData['client']     = $client;
                $nData['send']       = $send;
                $nData['email']      = $val->email;
                $nData['phone']      = $val->phone;
                $nData['cell']       = $val->cell;
                $nData['city']       = $val->city;
                $nData['state']      = $val->state;
                $nData['zip_code']   = $val->zip_code;
                $nData['ip']         = $val->ip;
                $nData['id']         = $val->id;
                $nData['icon_star']  = $icon_star;
                $nData['icon_flag']  = $icon_flag;
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
     * @param $input
     * @param $id
     * @return bool
     */
    public function response($input, $id)
    {
        $data   = $this->model->find($id);
        $update = $data->update($input);
        if ($update) {
            generateAccessesTxt(date('H:i:s').utf8_decode(' Respondeu o contato:'.$data->name));
            generateAccessesTxt(utf8_decode('Assunto: '.$data->subject));
            generateAccessesTxt(utf8_decode('Mensagem: '.$data->message));
            generateAccessesTxt(utf8_decode('Resposta: '.$data->return));
            return $data;
        }

        return false;
    }

    /**
     * @param $input
     * @param $id
     * @return bool
     */
    public function status($input, $id)
    {
        $data   = $this->model->find($id);
        $update = $data->update($input);

        if ( $input['status'] == 1 ) {
            $status = 'Estrela';
        }
        if ( $input['status'] == 2 ) {
            $status = 'Marcação';
        }
        if ($update) {
            generateAccessesTxt(date('H:i:s').
                utf8_decode(' Alterou o status do contato:'.$data->id.
                ', Status:'.$status));
            return true;
        }

        return false;
    }

    /**
     * @param $input
     * @return bool
     */
    public function create($input)
    {
        $data = $this->model->create($input);
        if ($data) {
            generateAccessesTxt(
                date('H:i:s').utf8_decode(
                    ' Adicionou o Contato:'.$data->name.
                    ', Mensagem: '.$data->message)
            );

            return $data;
        }

        return false;

    }

    /**
     * @param $id
     * @return bool
     */
    public function delete($id)
    {
        $data = $this->model->find($id);
        $delete = $data->delete();
        if ($delete) {
            generateAccessesTxt(
                date('H:i:s').utf8_decode(
                    ' Removeu o Contato:'.$data->name.
                    ', Mensagem: '.$data->message)
            );
            return $data;
        }

        return false;
    }



}