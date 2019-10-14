<?php

namespace AVDPainel\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Str;


class AdminAjaxDataController extends BaseController
{
    use DispatchesJobs;

    protected $options = false;
    protected $select  = false;
    protected $upload  = false;
    protected $slug    = false;



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if( Gate::denies("{$this->ability}-view") ) {
            return view("backend.erros.message-401");
        }

        $this->access->update($this->last_url);

        $data         = $this->interModel->getAll();
        $title        = $this->messages['title_index'];
        $title_create = $this->messages['title_create'];

        return view("{$this->view}.index", compact('data', 'title', 'title_create'));
    }

    /**
     * Form para adicionar
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if( Gate::denies("{$this->ability}-create") ) {
            return view("backend.erros.message-401");
        }

        $title = $this->messages['title_create'];
        $options = $this->options;


        if ($this->select['create'] == true) {
            if ($this->select['type'] == 'pluck') {
                $options = $this->select['table']
                           ->pluck($this->select['name'], 
                           $this->select['id']);
            }
        }

        return view("{$this->view}.form-create", compact('title', 'options'));

    }

    /**
     * Salvar o form especificado.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if( Gate::denies("{$this->ability}-create") ) {
            return view("backend.erros.message-401");
        }

        $this->interModel->rules($request, $this->messages);

        $dataForm = $request->all();

        if ($this->slug) {
            foreach ($this->slug as $slug => $label) {
                $dataForm[$slug]  = Str::slug($dataForm[$label], $this->slug);
            }            
        }
        
        if ( $this->upload && $request->hasFile($this->upload['name']) ) {

            $image  = $request->file($this->upload['name']);

            $name   = uniqid(date('YmdHis')).'.'.$image->getClientOriginalExtension();
            
            $upload = $image->storeAs($this->upload['path'], $name);

            if ($upload) {
                $dataForm[$this->upload['name']] = $name;
            }
            else {
                $success = false;
                $message = $this->messages['upload_false'];
            }
        }

        $data = $this->interModel->create($dataForm);

        if ($data) {

            $success = true;
            $message = $this->messages['store_true'];
        }
        else {
            $success = false;
            $message = $this->messages['store_false'];
        }


        $out = array(
            "success"  => $success,
            "message"  => $message,
            "delete"   => route($this->route_delete, $data->id),
            "edit"     => route($this->route_edit, $data->id),
            'token'    => csrf_token(),
            "data"     => $data
        );

        return response()->json($out);
    }

    /**
     * Exibir o modulo especificado.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

        if( Gate::denies("{$this->ability}-view") ) {
            return view("backend.erros.message-401");
        }

        $data         = $this->interModel->setId($id);
        $title        = $this->messages['title_index'];
        $title_create = $this->messages['title_index'];


        return view("{$this->view}.index", compact('data', 'title', 'title_create'));
        
    }

    /**
     * Form para editar o modulo especificado.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if( Gate::denies("{$this->ability}-update") ) {
            return view("backend.erros.message-401");
        }

        $data    = $this->interModel->setId($id);
        $title   = $this->messages['title_edit'];
        $options = $this->options;
        
        if ($this->select['edit'] == true) {
            if ($this->select['type'] == 'pluck') {
                $options = $this->select['table']
                           ->pluck($this->select['name'], 
                           $this->select['id']);
            }
        }

        return view("{$this->view}.form-edit", compact('data', 'title', 'options'));

    }

    /**
     * Atualizar o modulo especificado.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if( Gate::denies("{$this->ability}-update") ) {
            return view("backend.erros.message-401");
        }

        $this->interModel->rules($request, $this->messages, $id);

        $dataForm = $request->all();
       
        //Verifica se existe a imagem
        if( $this->upload && $request->hasFile($this->upload['name']) ) {
            //Pega a imagem
            $image = $request->file($this->upload['name']);
            $data  = $this->interModel->setId($id);

            //Verifica se o nome da imagem não existe
            if( $data->image == '' ){
                $name = uniqid(date('YmdHis')).'.'.$image->getClientOriginalExtension();
                $dataForm[$this->upload['name']] = $name;
            }else {
                $name = $data->image;
                $dataForm[$this->upload['name']] = $data->image;
            }
            
            $upload = $image->storeAs($this->upload['path'], $name);
            
            if ( $upload ) {
                $dataForm[$this->upload['name']] = $name;
            } else {
                $success = false;
                $message = $this->messages['upload_false'];
            }
        }

        $data = $this->interModel->update($dataForm, $id);
        if( $data ) {
            $success = true;
            $message = $this->messages['update_true'];
        } else {
            $success = false;
            $message = $this->messages['update_false'];
        }


        $out = array(
            "success" => $success,
            "message" => $message,
            "data"    => $data
        );
        return response()->json($out);
    }

    /**
     * Remover o modulo especificado.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        if( Gate::denies("{$this->ability}-delete") ) {
            return view("backend.erros.message-401");
        }

        $delete = $this->interModel->delete($id);

        if( $delete ) {
            $success = true;
            $message = $this->messages['delete_true'];
        } else {
            $success = false;
            $message = $this->messages['delete_false'];
        }

        $out = array(
            "success" => $success,
            "message" => $message
        );

        return response()->json($out);
    }

}
