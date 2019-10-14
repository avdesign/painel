<?php

namespace AVDPainel\Repositories\Admin;


use AVDPainel\Models\Admin\ContactSpam as Model;
use AVDPainel\Interfaces\Admin\ContactSpamInterface;
use AVDPainel\Interfaces\Admin\ContactInterface as InterContact;

use Illuminate\Foundation\Validation\ValidatesRequests;

class ContactSpamRepository implements ContactSpamInterface
{
    use ValidatesRequests;

    public $model;

    /**
     * Create construct.
     *
     * @return void
     */
    public function __construct(Model $model, InterContact $interContact)
    {
        $this->model         = $model;
        $this->interContact  = $interContact;
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
            2  => 'email',
            3  => 'message',
            4  => 'client',
            5  => 'send',
            6  => 'subject',
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
                $query =  $this->model->where('name','LIKE',"%{$search}%")
                    ->orWhere('subject', 'LIKE',"%{$search}%")
                    ->orWhere('email', 'LIKE',"%{$search}%")
                    ->orWhere('message', 'LIKE',"%{$search}%")
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy($order,$dir)
                    ->get();

                $totalFiltered = $this->model->where('name','LIKE',"%{$search}%")
                    ->orWhere('subject', 'LIKE',"%{$search}%")
                    ->orWhere('email', 'LIKE',"%{$search}%")
                    ->orWhere('message', 'LIKE',"%{$search}%")
                    ->count();
            } else {
                $totalFiltered =[];
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
                $nData['email']      = $val->email;
                $nData['message']    = $val->message;
                $nData['client']     = $client;
                $nData['send']       = $send;
                $nData['subject']    = $val->subject;
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
     * @param $id
     * @return mixed
     */
    public function setId($id)
    {
        return $this->model->find($id);
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
                    ' Adicionou a mensagem como spam, Contato:'.$data->name.
                    ', Mensagem: '.$data->message)
            );

            return $data;
        }

        return false;
    }

    public function update($input, $id)
    {
        $data  = $this->model->find($id);
        $input = $data->toArray();

        $input['admin'] = auth()->user()->name;

        $contact = $this->interContact->create($input);
        if ($contact) {

            $delete = $data->delete();

            if ($delete) {
                generateAccessesTxt(
                    date('H:i:s').utf8_decode(
                        ' Mudou o spam para Contato:'.$data->name.
                        ', Descrição:'.$data->message)
                );

                return true;
            }
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
                    ' Excluiu o Spam:'.$data->name.
                    ', Mensagem: '.$data->message)
            );
            return true;
        }
    }






}