<?php

namespace AVDPainel\Http\Controllers\Admin;

use AVDPainel\Http\Controllers\Controller;
use AVDPainel\Interfaces\Admin\OrderInterface as InterModel;
use AVDPainel\Interfaces\Admin\ConfigFreightInterface as ConfigFreight;
use AVDPainel\Interfaces\Admin\AdminAccessInterface as InterAccess;
use AVDPainel\Interfaces\Admin\ConfigSystemInterface as ConfigSystem;
use AVDPainel\Interfaces\Admin\ConfigColorPositionInterface as ConfigImages;


use AVDPainel\Interfaces\Admin\UserInterface as InterUser;
use AVDPainel\Interfaces\Admin\ConfigStatusPaymentInterface as StatusPayment;
use AVDPainel\Interfaces\Admin\ConfigFormPaymentInterface as FormPayment;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Crypt;


class OrderController extends Controller
{
    protected $ability  = 'orders';
    protected $view     = 'backend.orders';
    protected $select;
    protected $last_url;
    protected $messages;

    public function __construct(
        InterAccess $access,
        InterUser $interUser,
        InterModel $interModel,
        ConfigSystem $confUser,
        FormPayment $formPayment,
        ConfigImages $configImages,
        ConfigFreight $configFreight,
        StatusPayment $statusPayment)
    {
        $this->middleware('auth:admin');

        $this->access        = $access;
        $this->confUser      = $confUser;
        $this->interUser     = $interUser;
        $this->interModel    = $interModel;
        $this->formPayment   = $formPayment;
        $this->configImages  = $configImages;
        $this->configFreight = $configFreight;
        $this->statusPayment = $statusPayment;
        $this->last_url      = array('last_url' => 'orders');
        $this->messages = array(
            'user_id.required'                  => 'O código do cliente é obrigatório.',
            'config_status_payment_id.required' => 'O status do pedido é obrigatório.',
            'config_form_payment_id.required'   => 'A forma de pagamento é obrigatória.',
            'user_false'                        => 'Não existe este código registrado.',
            'title_index'                       => 'Pedidos',
            'title_create'                      => 'Adicionar Pedido',
            'title_edit'                        => 'Alterar Pedido',
            'title_printer'                     => 'Imprimir',
            'title_download'                    => 'Download',
            'store_true'                        => 'O pedido foi adicionado.',
            'store_false'                       => 'Não foi possível adicionar o pedido.',
            'update_true'                       => 'O pedido foi alterado.',
            'update_false'                      => 'Não foi possível alterar opedido.',
            'delete_true'                       => 'O pedido foi excluido.',
            'delete_false'                      => 'Não foi possível excluir o pedido.',
            'reactivate_true'                   => 'O pedido foi reativado.',
            'reactivate_false'                  => 'Não foi possível reativado o pedido.'
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

        $title          = $this->messages['title_index'];
        $confUser       = $this->confUser->get();
        $title_edit     = $this->messages['title_edit'];
        $title_create   = $this->messages['title_create'];
        $title_printer  = $this->messages['title_printer'];
        $title_download = $this->messages['title_download'];

        return view("{$this->view}.index", compact(
            'title',
            'title_create',
            'title_printer',
            'title_download',
            'title_edit',
            'confUser'));
    }

    /**
     * Table getAll()
     *
     * @param  array  $request
     * @return json
     */
    public function data(Request $request)
    {
        if( Gate::denies("{$this->ability}-view") ) {
            return view("backend.erros.message-401");
        }

        $data = $this->interModel->getAll($request);

        return response()->json($data);
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        if( Gate::denies("{$this->ability}-create") ) {
            return view("backend.erros.message-401");
        }


        $forms    = $this->formPayment->pluck();
        $status   = $this->statusPayment->pluck();

        return view("{$this->view}.form-create", compact('status','forms'));
    }

    /**
     * @param Request $request
     * @return Json
     */
    public function store(Request $request)
    {
        if( Gate::denies("{$this->ability}-create") ) {
            return view("backend.erros.message-401");
        }

        $this->interModel->rules($request, $this->messages);

        $dataForm = $request->all();


        if ( count($this->interUser->createOrder($dataForm['user_id']) ) <= 0) {
            $success = false;
            $message = $this->messages['user_false'];

        } else {

            $form              = $this->formPayment->setId($dataForm['config_form_payment_id']);
            $status            = $this->statusPayment->setId('config_status_payment_id');
            $dataForm['ip']    = $request->ip();
            $dataForm['token'] = Crypt::encryptString(auth()->user()->name.time());

            $insert = $this->interModel->create($dataForm,$status,$form);

            if ($insert) {
                $this->generatePdf($insert->id, 'store');
                $success = true;
                $message = $this->messages['store_true'];
            }
            else {
                $success = false;
                $message = $this->messages['store_false'];
            }

        }


        $out = array(
            "success" => $success,
            "message" => $message
        );

        return response()->json($out);
    }

    /**
     * @param $id
     * @return View
     */
    public function edit($id)
    {
        if( Gate::denies("{$this->ability}-update") ) {
            return view("backend.erros.message-401");
        }
        $data  = $this->interModel->setId($id);

        $title = $this->messages['title_edit'];

        $forms    = $this->formPayment->pluck();
        $status   = $this->statusPayment->pluck();
        $configFreight = $this->configFreight->setId(1);

        return view("{$this->view}.form-edit", compact('data', 'configFreight', 'forms', 'title', 'status'));

    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        if( Gate::denies("{$this->ability}-update") ) {
            return view("backend.erros.message-401");
        }

        $this->interModel->rules($request, $this->messages, $id);

        $dataForm = $request->all();

        $update = $this->interModel->update($dataForm, $id);
        if( $update ) {

            $this->generatePdf($id);
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
     * @param $id
     * @return \Illuminate\Http\JsonResponse
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

    /**
     * @param $id
     * @return View
     */
    public function details($id)
    {
        if( Gate::denies("{$this->ability}-view") ) {
            return view("backend.erros.message-401");
        }

        $data          = $this->interModel->setId($id);
        $user          = $data->user()->first();
        $address       = $user->adresses()->orderBy('id', 'desc')->first();
        $configFreight = $this->configFreight->setId(1);
        $shippings     = $data->shippings;
        $shipping      = '';

        foreach ($shippings as $transport) {
            if ($transport->indicate == 1) {
                $shipping .= "<h4 class=\"blue underline\">Indicou Transportadora:</h4>";
                $shipping .= "<p>Transportadora: <strong>{$shippings[0]->name}</strong></p>";
                $shipping .= "<p>Telefone: <strong>{$shippings[0]->phone}</strong></p>";
            }
        }

        return view("{$this->view}.details", compact(
            'configFreight','data','user','address','shipping')
        );
    }

    /**
     * @return View
     */
    public function show(){

        if( Gate::denies("{$this->ability}-view") ) {
            return view("backend.erros.message-401");
        }

        $title        = $this->messages['title_index'];
        $confUser     = $this->confUser->get();
        $title_edit   = $this->messages['title_edit'];
        $title_create = $this->messages['title_create'];

        return view("{$this->view}.excluded", compact('title', 'title_create', 'title_edit','confUser'));
    }

    /**
     * Table getAll()
     *
     * @param  array  $request
     * @return json
     */
    public function dataExcluded(Request $request)
    {
        if( Gate::denies("{$this->ability}-view") ) {
            return view("backend.erros.message-401");
        }

        $data = $this->interModel->getExcluded($request);

        return response()->json($data);
    }


    public function reactivate(Request $request, $id)
    {
        if( Gate::denies("{$this->ability}-delete") ) {
            return view("backend.erros.message-401");
        }

        $reactivate = $this->interModel->reactivate($id);
        if($reactivate) {
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


    /**
     * @param $order_id
     * @return Json
     */
    public function printerPdf($order_id)
    {
        if( Gate::denies("{$this->ability}-view") ) {
            return view("backend.erros.message-401");
        }

        $order = $this->interModel->setId($order_id);
        if (empty($order)) {
            return redirect()->back();
        } else {
            return printerOrderPdf($order);
        }
    }


    /**
     * @param $order_id
     * @return Json
     */
    public function downloadPdf($order_id)
    {
        if( Gate::denies("{$this->ability}-view") ) {
            return view("backend.erros.message-401");
        }

        $order   = $this->interModel->setId($order_id);
        if (count($order) == 0) {
            return redirect()->back();
        } else {

            return printerOrderPdf($order);

        }
    }



    /**
     * Gerar e atualizar  arquivo pdf
     * @param $order_id
     * @param null $method
     */
    public function generatePdf($order_id, $method=null)
    {
        $order  = $this->interModel->setId($order_id);
        $image  = $this->configImages->setName('default','T');
        generateOrderPdf($order, $image, $method);
    }
}
