<?php

namespace AVDPainel\Repositories\Admin;


use AVDPainel\Models\Admin\User as Model;
use AVDPainel\Interfaces\Admin\UserInterface;

use Illuminate\Support\Facades\Gate;

class UserRepository implements UserInterface
{

    public $model;

    /**
     * Create construct.
     *
     * @return void
     */
    public function __construct(Model $model)
    {
        $this->model    = $model;
    }

    /**
     * @return mixed
     */
    public function pluck()
    {
        return $this->model->pluck('name', 'id');
    }

    /**
     * @return mixed
     */
    public function get()
    {
        $data  = $this->model->get();
        return $data;    
    }

    /**
     * @param $request
     * @return array Json
     */
    public function getAll($request)
    {
        $columns = array(
            0  => 'id',
            1  => 'profile_id',
            2  => 'first_name',
            3  => 'admin',
            4  => 'visits',
            5  => 'active',
            6  => 'last_name',
            7  => 'email',
            8  => 'document1',
            9  => 'document2',
            10 => 'phone',
            11 => 'cell',
            12 => 'client',
            13 => 'date',
            14 => 'newsletter',
            15 => 'ip',
            16 => 'last_login',
            17 => 'logout',
            18 => 'created_at',
            19 => 'updated_at',
            20 => 'deleted_at'

        );

        $totalData = $this->model->count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir   = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $query = $this->model->with(array(
                'profile' => function ($query) {
                    $query->orderBy('id', 'desc');
                }
            ))
            ->with(array(
                'notes' => function ($query) {
                    $query->orderBy('id', 'desc');
                }
            ))
            ->offset($start)
            ->limit($limit)
            ->orderBy($order,$dir)
            ->get();
        } else {

            $search = $request->input('search.value');
            $query =  $this->model->where('id','LIKE',"%{$search}%")
                ->orWhere('first_name', 'LIKE',"%{$search}%")
                ->orWhere('last_name', 'LIKE',"%{$search}%")
                ->orWhere('email', 'LIKE',"%{$search}%")
                ->orWhere('document1', 'LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();

            $totalFiltered = $this->model->where('id','LIKE',"%{$search}%")
                ->orWhere('first_name', 'LIKE',"%{$search}%")
                ->orWhere('last_name', 'LIKE',"%{$search}%")
                ->orWhere('email', 'LIKE',"%{$search}%")
                ->orWhere('document1', 'LIKE',"%{$search}%")
                ->count();

        }


        $data  = array();
        if(!empty($query))
        {
            foreach ($query as $val){

                if ($val->profile_id == 3) {
                    $html_name  = "<p>Razão Social: <strong> {$val->first_name} </strong></p>";
                    $html_name .= "<p>Nome Fantasia: <strong> {$val->last_name} </strong></p>";
                    $html_document  = "<p>CNPJ: <strong> {$val->document1} </strong></p>";
                    $html_document .= "<p>Inscrição Estadual: <strong> {$val->document2} </strong></p>";
                } else {
                    $html_name = "<p>Nome: <strong> {$val->first_name} {$val->last_name} </strong></p>";
                    $html_document  = "<p>CPF: <strong> {$val->document1} </strong></p>";
                    $html_document .= "<p>RG: <strong> {$val->document2} </strong></p>";

                }

                $count_notes = count($val->notes);
                ($count_notes >= 1 ? $notes = '<small class="tag red-bg">Observações: '.$count_notes.'</small>' : $notes = '');

                ($val->client == 1 ? $client = '<small class="tag">Sim</small>' :
                    $client = '<small class="tag red-bg">Não</small>');

                ($val->active == constLang('active_true') ? $active = '<small class="tag">'.constLang('active_true').'</small>' :
                    $active = '<small class="tag red-bg">'.constLang('active_false').'</small>');

                ($val->newsletter == 1 ? $newsletter = '<small class="tag">Ativo</small>' :
                    $newsletter = '<small class="tag red-bg">Inativo</small>');

                ($val->last_login == null ? $last_login = '' :
                    $last_login = date('d/m/Y H:i:s', strtotime($val->last_login)));

                ($val->logout == null ? $logout = '' :
                    $logout = date('d/m/Y H:i:s', strtotime($val->logout)));

                $nData['id']          = $val->id;
                $nData['profile_id']  = $val->profile->name;
                if ($val->profile_id == 3) {
                    $nData['first_name']  = $val->first_name.'<br/>'.$val->last_name;
                } else {
                    $nData['first_name']  = $val->first_name.' '.$val->last_name;
                }
                $nData['admin']         = $val->admin;
                $nData['visits']        = $val->visits;
                $nData['active']        = $active;
                $nData['html_name']     = $html_name;
                $nData['html_document'] = $html_document;

                $nData['last_name']   = $val->last_name;
                $nData['email']       = $val->email;
                $nData['document1']   = $val->document1;
                $nData['document2']   = $val->document2;
                $nData['phone']       = $val->phone;
                $nData['cell']        = $val->cell;
                $nData['client']      = $client;
                $nData['date']        = $val->date;
                $nData['newsletter']  = $newsletter;
                $nData['created_at']  = date('d/m/Y H:i:s', strtotime($val->created_at));
                $nData['updated_at']  = date('d/m/Y H:i:s', strtotime($val->updated_at));
                $nData['last_login']  = $last_login;
                $nData['logout']      = $logout;
                if ($val->deleted_at != null) {
                    $nData['deleted_at']  = date('d/m/Y H:i:s', strtotime($val->deleted_at));
                } else {
                    $nData['deleted_at']  = $val->deleted_at;
                }
                $nData['ip']          = $val->ip;
                $nData['count_notes'] = $count_notes;
                $nData['notes']       = $notes;
                $data[] = $nData;

            }
        }

        $out = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data,
        );



        return $out;
    }

    /**
     * @param $input
     * @param $id
     * @return bool
     */
    public function updateAdmin($input, $id)
    {
        $data   = $this->model->find($id);
        $update = $data->update($input);
        if ($update) {
            generateAccessesTxt(
                date('H:i:s').utf8_decode(
                    ' Alterou (Atendente) Cliente:'.$data->first_name.
                    ', Admin:'.$input['admin'])
            );
            return true;
        }
        return false;
    }

    /**
     * @param $name
     * @return mixed
     */
    public function countAdmin($name)
    {
        return $this->model->where(['active' => constLang('active_true'), 'admin' => $name])->get()->count();
    }

    /**
     * @param $id
     * @return mixed
     */
    public function setId($id)
    {
        return $this->model->withTrashed()->find($id);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function createOrder($id)
    {
        return $this->model->find($id);
    }


    /**
     * Create
     *
     * @param  array $input
     * @return mixed
     */
    public function create($input)
    {
        $data = $this->model->create($input);
        if ($data) {
            generateAccessesTxt(
                date('H:i:s').utf8_decode(' Adicionou o cliente Código:'.$data->id)
            );
            return $data;
        }
        return false;
    }

    /**
     * @param $input
     * @param $id
     * @return bool
     */
    public function update($input, $id)
    {
        $data   = $this->setId($id);
        $update = $data->update($input);
        if ($update) {
            generateAccessesTxt(
                date('H:i:s').utf8_decode(' Alterou o perfil do cliente Código:'.$data->id)
            );
            return true;
        }
        return false;
    }

    /**
     * @param $id
     * @return bool
     */
    public function delete($id)
    {
        $data   = $this->setId($id);
        $delete = $data->delete();
        if ($delete) {
            generateAccessesTxt(
                date('H:i:s').utf8_decode(' Excluiu o Cliente:'.$data->id)
            );
            return true;
        }

        return false;
    }

    /**
     * @param $request
     * @return array
     */
    public function getExcluded($request)
    {
        $columns = array(
            0  => 'id',
            1  => 'profile_id',
            2  => 'first_name',
            3  => 'admin',
            4  => 'visits',
            5  => 'active',
            6  => 'last_name',
            7  => 'email',
            8  => 'document1',
            9  => 'document2',
            10 => 'phone',
            11 => 'cell',
            12 => 'client',
            13 => 'date',
            14 => 'newsletter',
            15 => 'ip',
            16 => 'last_login',
            17 => 'logout',
            18 => 'created_at',
            19 => 'updated_at',
            20 => 'deleted_at'

        );

        $totalData = $this->model->onlyTrashed()->count();

        $totalFiltered = $totalData;

        $limit = $request->input('length');
        $start = $request->input('start');
        $order = $columns[$request->input('order.0.column')];
        $dir   = $request->input('order.0.dir');

        if (empty($request->input('search.value'))) {
            $query = $this->model->onlyTrashed()->with(array(
                'profile' => function ($query) {
                    $query->orderBy('id', 'desc');
                }
            ))
                ->with(array(
                    'adresses' => function ($query) {
                        $query->where('delivery', 1)->first();
                    }
                ))
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();
        } else {

            $search = $request->input('search.value');
            $query =  $this->model->onlyTrashed()->where('first_name','LIKE',"%{$search}%")
                ->orWhere('last_name', 'LIKE',"%{$search}%")
                ->orWhere('email', 'LIKE',"%{$search}%")
                ->orWhere('document1', 'LIKE',"%{$search}%")
                ->offset($start)
                ->limit($limit)
                ->orderBy($order,$dir)
                ->get();

            $totalFiltered = $this->model->onlyTrashed()->where('first_name','LIKE',"%{$search}%")
                ->orWhere('last_name', 'LIKE',"%{$search}%")
                ->orWhere('email', 'LIKE',"%{$search}%")
                ->orWhere('document1', 'LIKE',"%{$search}%")
                ->count();

        }


        $data  = array();
        if(!empty($query))
        {
            foreach ($query as $val){

                if ($val->profile_id == 3) {
                    $html_name  = "<p>Razão Social: <strong> {$val->first_name} </strong></p>";
                    $html_name .= "<p>Nome Fantasia: <strong> {$val->last_name} </strong></p>";
                    $html_document  = "<p>CNPJ: <strong> {$val->document1} </strong></p>";
                    $html_document .= "<p>Inscrição Estadual: <strong> {$val->document2} </strong></p>";
                } else {
                    $html_name = "<p>Nome: <strong> {$val->first_name} {$val->last_name} </strong></p>";
                    $html_document  = "<p>CPF: <strong> {$val->document1} </strong></p>";
                    $html_document .= "<p>RG: <strong> {$val->document2} </strong></p>";

                }

                ($val->client == 1 ? $client = '<small class="tag">Sim</small>' :
                    $client = '<small class="tag red-bg">Não</small>');

                ($val->active == constLang('active_true') ? $active = '<small class="tag">'.constLang('active_true').'</small>' :
                    $active = '<small class="tag red-bg">'.constLang('active_false').'</small>');

                ($val->newsletter == 1 ? $newsletter = '<small class="tag">Ativo</small>' :
                    $newsletter = '<small class="tag red-bg">Inativo</small>');

                ($val->last_login == null ? $last_login = '' :
                    $last_login = date('d/m/Y H:i:s', strtotime($val->last_login)));

                ($val->logout == null ? $logout = '' :
                    $logout = date('d/m/Y H:i:s', strtotime($val->logout)));


                $nData['id']          = $val->id;
                $nData['profile_id']  = $val->profile->name;
                if ($val->profile_id == 3) {
                    $nData['first_name']  = $val->first_name.'<br/>'.$val->last_name;
                } else {
                    $nData['first_name']  = $val->first_name.' '.$val->last_name;
                }
                $nData['admin']         = $val->admin;
                $nData['visits']        = $val->visits;
                $nData['active']        = $active;
                $nData['html_name']     = $html_name;
                $nData['html_document'] = $html_document;

                $nData['last_name']   = $val->last_name;
                $nData['email']       = $val->email;
                $nData['document1']   = $val->document1;
                $nData['document2']   = $val->document2;
                $nData['phone']       = $val->phone;
                $nData['cell']        = $val->cell;
                $nData['client']      = $client;
                $nData['date']        = $val->date;
                $nData['newsletter']  = $newsletter;
                $nData['created_at']  = date('d/m/Y H:i:s', strtotime($val->created_at));
                $nData['updated_at']  = date('d/m/Y H:i:s', strtotime($val->updated_at));
                $nData['last_login']  = $last_login;
                $nData['logout']      = $logout;
                $nData['deleted_at']  = date('d/m/Y H:i:s', strtotime($val->deleted_at));
                $nData['ip']          = $val->ip;
                $data[] = $nData;

            }
        }

        $out = array(
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($totalData),
            "recordsFiltered" => intval($totalFiltered),
            "data" => $data,
        );

        return $out;
    }

    /**
     * @param $id
     * @return bool
     */
    public function reactivate($id)
    {
        $data = $this->model->withTrashed()->find($id);
        if ( $data->restore() ){
            generateAccessesTxt(
                date('H:i:s').utf8_decode(
                    ' Reativou o cliente - Código: '.$data->id.
                    ', Nome: '.$data->first_name.
                    ', Email: '.$data->email)
            );
            return true;
        }

        return false;
    }


}