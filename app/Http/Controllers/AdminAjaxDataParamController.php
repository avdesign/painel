<?php

namespace AVDPainel\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Str;


class AdminAjaxDataParamController extends BaseController
{
    use DispatchesJobs;

    protected $options = false;
    protected $select  = false;
    protected $upload  = false;
    protected $access  = false;
    protected $slug    = false;

    /**
     * Index
     * @param  int  $id  model
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        if( Gate::denies("{$this->ability}-view") ) {
            return view("backend.erros.message-401");
        }

        $upload = $this->upload;
        $title  = $this->messages['title_index'];
        $data   = $this->interModel->getAll($id);

        return view("{$this->view}", compact('id', 'data', 'title', 'upload'));
    }

    /**
     * Form Create
     * @param  int  $id  model
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        if( Gate::denies("{$this->ability}-create") ) {
            return view("backend.erros.message-401");
        }
        $upload  = $this->upload;
        $options = $this->options;

        if ($this->select['create'] == true) {
            if ($this->select['type'] == 'pluck') {
                $options = $this->select['table']
                           ->pluck($this->select['name'],
                           $this->select['id']);
            }

        }

        return view("{$this->view}-form-create", compact('id', 'options', 'upload'));

    }

    /**
     * Store create.
     *
     * @param  int  $id 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $id)
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

            $dataForm['config'] = $this->upload;
        }

        $insert = $this->interModel->create($dataForm, $id);

        return response()->json($insert);    

    }

    /**
     * Show.
     *
     * @param  int  $id
     * @param  int  $mod  id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $mod)
    { 
        /*
        if( Gate::denies("{$this->ability}-view") ) {
            return view("backend.erros.message-401");
        }

        $data = $this->interModel->setId($mod);
        */
    }



    /**
     * Form edit
     *
     * @param  int  $id
     * @param  int  $mode
     * @return \Illuminate\Http\Response
     */
    public function edit($id, $mod)
    {
        if( Gate::denies("{$this->ability}-update") ) {
            return view("backend.erros.message-401");
        }

        $data    = $this->interModel->setId($mod);
        $upload  = $this->upload;
        $options = $this->options;

        if ($this->select['edit'] == true) {
            if ($this->select['type'] == 'pluck') {
                $options = $this->select['table']
                           ->pluck($this->select['name'], 
                           $this->select['id']);
            }
        }

        return view("{$this->view}-form-edit", compact('id', 'data', 'options', 'upload'));
    }

    /**
     * Atualizar o modulo especificado.
     *
     * @param  int  $id
     * @param  int  $mode
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id, $mod)
    {

        if( Gate::denies("{$this->ability}-update") ) {
            return view("backend.erros.message-401");
        }

        $this->interModel->rules($request, $this->messages, $mod);

        $dataForm = $request->all();

        if ( $this->upload && $request->hasFile($this->upload['name']) ) {

            $dataForm['config'] = $this->upload;
        }
     

        $data = $this->interModel->update($dataForm, $id, $mod);

        return response()->json($data);    

    }

    /**
     * Remove
     *
     * @param  int  $id  
     * @param  int  $mod  id 
     * @return \Illuminate\Http\Response
     */
    public function destroy($id, $mod)
    {
        if( Gate::denies("{$this->ability}-delete") ) {
            return view("backend.erros.message-401");
        }

        if ( $this->upload ) {
            $delete = $this->interModel->delete($mod, $this->upload);
        } else {
            $delete = $this->interModel->delete($mod);
        }

        if ($delete) {
            $success = true;
            $message = $this->messages['delete_success'];
        } else {
            $message = $this->messages['delete_error'];
            $success = false;
        }

        $out = array(
            'success' => $success,
            'message' => $message
        );

        return response()->json($out);
    }

}
