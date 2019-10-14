<?php

namespace AVDPainel\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Str;


class AdminAjaxTablesController extends BaseController
{
    use DispatchesJobs;

    protected $configImages = false;
    protected $configModel  = false;
    protected $options      = false;
    protected $select       = false;
    protected $upload       = false;
    protected $slug         = false;



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

        $data         = $this->interModel->get();
        $title        = $this->messages['title_index'];
        $confUser     = $this->confUser->get();
        $title_create = $this->messages['title_create'];
        $configModel  = $this->configModel;

        return view("{$this->view}.index", compact('data', 'configModel', 'title', 'title_create', 'confUser'));    
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

        $configModel = $this->configModel;
        $options     = $this->options;
        $title       = $this->messages['title_index'];

        if ($this->select['create'] == true) {
            if ($this->select['type'] == 'pluck') {
                $options = $this->select['table']
                           ->pluck($this->select['name'], 
                           $this->select['id']);
            }
        }


        return view("{$this->view}.form-create", compact(
            'title', 'configModel', 'options'
        ));

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

        $insert = $this->interModel->create($dataForm);

        if ($insert) {

            $success = true;
            $message = $this->messages['store_true'];
        }
        else {
            $success = false;
            $message = $this->messages['store_false'];
        }


        $out = array(
            "success" => $success,
            "message" => $message
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
        $title        = $this->messages['title'];
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

        $configModel = $this->configModel;
        $options     = $this->options;
        $title       = $this->messages['title_edit'];
        $data        = $this->interModel->setId($id);

        if ($this->select['edit'] == true) {
            if ($this->select['type'] == 'pluck') {
                $options = $this->select['table']
                           ->pluck($this->select['name'], 
                           $this->select['id']);
            }
        }


        return view("{$this->view}.form-edit", compact('data', 'configModel', 'title', 'options'));

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

        $update = $this->interModel->update($dataForm, $id);
        if( $update ) {

            $success = true;
            $message = $this->messages['update_true'];
        } else {
            $success = false;
            $message = $this->messages['update_false'];
        }


        $out = array(
            "success" => $success,
            "message" => $message
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

        if ($this->upload) {
            if ($this->configImages) {
                $delete = $this->interModel->delete($id, $this->upload, $this->configImages);
            } else {
                $delete = $this->interModel->delete($id, $this->upload);
            }
        } else {
            if ($this->configImages) {
                $delete = $this->interModel->delete($id, $this->configImages);
            } else {
                $delete = $this->interModel->delete($id);
            }
        }

        if( $delete ) {
            $success = true;
            $message = $this->messages['delete_true'];
            $deleted = $delete;

        } else {
            $success = false;
            $message = $this->messages['delete_false'];
            $deleted = false;
        }

        $out = array(
            "success" => $success,
            "message" => $message,
            "deleted" => $deleted
        );

        return response()->json($out);
    }

}
