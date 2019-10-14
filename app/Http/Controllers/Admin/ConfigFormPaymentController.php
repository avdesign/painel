<?php

namespace AVDPainel\Http\Controllers\Admin;

use AVDPainel\Interfaces\Admin\AdminAccessInterface as InterAccess;
use AVDPainel\Interfaces\Admin\ConfigFormPaymentInterface as InterModel;
use AVDPainel\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ConfigFormPaymentController extends Controller
{

    protected $ability  = 'config-form-payment';
    protected $view     = 'backend.settings.forms-payments';
    protected $last_url;
    protected $messages;


    public function __construct(
        InterAccess $access,
        InterModel $interModel)
    {
        $this->middleware('auth:admin');

        $this->access     = $access;
        $this->interModel = $interModel;
        $this->last_url   = array("last_url" => "config/forms-payments");
        $this->messages   = array(
            "label.required"       => "O nome é obrigatório 2",
            "label.unique"         => "Esta status já se encontra utilizado.",
            "description.required" => "A descrição é obrigatória.",
            "order.required"       => "A ordem é obrigatória.",
            "active.required"      => "O status é obrigatório.",
            "title_index"          => "Forma de Pagamento",
            "title_create"         => "Adicionar forma de pagamento",
            "title_edit"           => "Alterar forma de pagamento",
            "create_true"          => "A forma de pagamento foi criada.",
            "create_false"         => "Não foi possível criar a forma de pagamento.",
            "update_true"          => "A forma de pagamento foi alterada.",
            "update_false"         => "Não foi possível alterar a forma de pagamento.",
            "delete_true"          => "A forma de pagamento foi excluida",
            "delete_false"         => "Não foi possível excluir a forma de pagamento.",
            "reactivate_true"      => "A forma de pagamento foi reativada",
            "reactivate_false"     => "Não foi possível reativar a forma de pagamento.",
            "title_excluded"       => "Forma de pagamento excluidas"
        );
    }

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
        $title_edit   = $this->messages['title_edit'];
        $title_create = $this->messages['title_create'];

        return view("{$this->view}.index", compact('data', 'title','title_edit','title_create'));
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

        return view("{$this->view}.form-create");
    }

    /**
     * Store a newly created resource in storage.
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

        $create = $this->interModel->create($dataForm);

        if ($create) {
            $success = true;
            $message = $this->messages['create_true'];
        } else {
            $success = false;
            $message = $this->messages['create_false'];
        }

        $out = array(
            'success' => $success,
            'message' => $message
        );

        return response()->json($out);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        if( Gate::denies("{$this->ability}-view") ) {
            return view("backend.erros.message-401");
        }

        $data = $this->interModel->getAll();

        return view("{$this->view}.show", compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if( Gate::denies("{$this->ability}-update") ) {
            return view("backend.erros.message-401");
        }

        $data  = $this->interModel->setId($id);
        $title = $this->messages['title_edit'];

        return view("{$this->view}.form-edit", compact('data', 'title'));
    }

    /**
     * Update the specified resource in storage.
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
        $update   = $this->interModel->update($dataForm, $id);
        if( $update ) {
            $success = true;
            $message = $this->messages['update_true'];
        } else {
            $success = false;
            $message = $this->messages['update_false'];
        }

        $out = array(
            'success' => $success,
            'message' => $message
        );

        return response()->json($out);
    }

    /**
     * Remove the specified resource from storage.
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


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function excluded()
    {
        if( Gate::denies("{$this->ability}-delete") ) {
            return view("backend.erros.message-401");
        }

        $data  = $this->interModel->getExcluded();
        $title = $this->messages['title_excluded'];


        return view("{$this->view}.excluded", compact('data', 'title'));
    }

    public function reactivate($id)
    {
        if( Gate::denies("{$this->ability}-delete") ) {
            return view("backend.erros.message-401");
        }
        $reactivate = $this->interModel->reactivate($id);

        if( $reactivate ) {
            $success = true;
            $message = $this->messages['reactivate_true'];
        } else {
            $success = false;
            $message = $this->messages['reactivate_false'];
        }

        $out = array(
            "success" => $success,
            "message" => $message
        );

        return response()->json($out);
    }

}
