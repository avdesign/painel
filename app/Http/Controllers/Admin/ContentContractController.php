<?php

namespace AVDPainel\Http\Controllers\Admin;

use AVDPainel\Interfaces\Admin\ContentContractInterface as InterModel;
use AVDPainel\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Gate;

class ContentContractController extends Controller
{
    protected $content = 'Conteúdo: Contrato compra e venda';
    protected $ability = 'contents-site';
    protected $view    = 'backend.contents.contracts';
    protected $model;


    public function __construct(InterModel $interModel)
    {

        $this->middleware('auth:admin');

        $this->interModel = $interModel;

        $this->messages = array(
            "fields" => array(
                'type' => 'Tipo',
                'title' => 'Titulo',
                'description' => "Descrição",
                'order' => 'Ordem',
                'active' => 'Status',
                'date' => 'Data'
            ),
            "accesses" => array(
                'create' => "Adicionou {$this->content} ",
                'update' => "Alterou {$this->content} ",
                'delete' => "Excluiu {$this->content} ",
            ),
            'type.required' => 'O tipo é obrigatório',
            'title.required' => 'O titulo é obrigatório',
            'description.required' => 'A descrição é obrigatória',
            'active.required' => 'O status é obrigatório',
            'order.required' => 'A ordem é obrigatória.',
            'order.numeric' => 'A ordem tem que ser numérica.',
            'title_index' => $this->content,
            'title_create' => 'Adicionar',
            'title_edit' => 'Editar',
            'create_true' => 'O registro foi salvo',
            'create_false' => 'Não foi possível salvar o registro',
            'update_true' => 'O registro foi alterado',
            'update_false' => 'Não foi possível alterar o registro',
            'delete_true' => 'O registro foi excluido',
            'delete_false' => 'Não foi possível excluir o registro',
            'error_serve' => 'Houve um erro no servidor.',
            'status_true' => 'O status foi alterado',
            'status_false' => 'Não foi possível alterar o status',
            'order_true' => 'A ordem foi alterada',
            'order_false' => 'Não foi possível alterar a ordem'
        );
    }



    public function index()
    {
        if( Gate::denies("{$this->ability}-view") ) {
            return view("backend.erros.message-401");
        }

        $data   = $this->interModel->getAll();
        $config = $this->messages;

        return view("{$this->view}.index", compact('config','data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if( Gate::denies("{$this->ability}-create") ) {
            return view("backend.erros.message-401");
        }

        $config = $this->messages;

        return view("{$this->view}.form-create", compact('config'));
    }

    /**
     * Adicionar registro
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

        $create = $this->interModel->create($dataForm, $this->messages);

        return response()->json($create);

    }


    /**
     * @param $id
     * @return View
     */
    public function show($id)
    {
        if( Gate::denies("{$this->ability}-update") ) {
            return view("backend.erros.message-401");
        }

        $data = $this->interModel->setId($id);

        return view("{$this->view}.form-edit", compact('data'));
    }

    /**
     * @param Request $request
     * @param $id
     * @return json
     */
    public function update(Request $request, $id)
    {
        if( Gate::denies("{$this->ability}-update") ) {
            return view("backend.erros.message-401");
        }

        $this->interModel->rules($request, $this->messages);

        $dataForm = $request->all();

        $update = $this->interModel->update($dataForm, $id, $this->messages);

        return response()->json($update);

    }

    public function destroy($id)
    {
        if( Gate::denies("{$this->ability}-delete") ) {
            return view("backend.erros.message-401");
        }

        $delete = $this->interModel->delete($id, $this->messages);

        return response()->json($delete);
    }

    /**
     * Retorna coma view atualizada
     * @return View
     */
    public function loadContent()
    {
        if( Gate::denies("{$this->ability}-view") ) {
            return view("backend.erros.message-401");
        }

        $data   = $this->interModel->getAll();
        $config = $this->messages;

        return view("{$this->view}.list", compact('data', 'config'));
    }

    /**
     * Alterar o status
     *
     * @param Request $request
     * @param $id
     * @return json
     */
    public function status(Request $request, $id)
    {
        if( Gate::denies("{$this->ability}-update") ) {
            return view("backend.erros.message-401");
        }

        $status = $this->interModel->status($id, $this->messages);

        return response()->json($status);
    }


    /**
     * @param $id
     * @return View
     */
    public function order($id)
    {
        if( Gate::denies("{$this->ability}-update") ) {
            return view("backend.erros.message-401");
        }

        $order = $this->interModel->getOrder($id);
        return view("{$this->view}.order", compact('order', 'id'));
    }

    /**
     * @param Request $request
     * @return json
     */
    public function updateOrder(Request $request)
    {
        if( Gate::denies("{$this->ability}-update") ) {
            return view("backend.erros.message-401");
        }
        $dataForm = $request->all();
        return $this->interModel->updateOrder($dataForm, $this->messages);
    }

}
