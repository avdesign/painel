<?php

namespace AVDPainel\Http\Controllers\Gateway;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

use AVDPainel\Http\Controllers\Controller;
use AVDPainel\Interfaces\Admin\OrderInterface as InterModel;
use AVDPainel\Services\Admin\PagSeguroServicesInterface as PagSeguroServices;

class PagSeguroController extends Controller
{

    protected $content;
    protected $ability  = 'gateway';
    protected $view     = 'backend.gateways.pagseguro';

    public function __construct(InterModel $model, PagSeguroServices $pagSeguroServices)
    {
        $this->middleware('auth:admin');

        $this->model = $model;
        $this->pagSeguroServices = $pagSeguroServices;
        $this->content = array(
            'company' => 'PagSeguro',
            'order' => 'Pedido',
            'status' => 'Status',
            'total' => 'Valor Total',
            'feeAmount' => 'Taxa Cobrada',
            'netAmount' => 'Valor a Receber',
            'messages' => array(
                'cancel_success' => 'O pedido foi cancelado',
                'cancel_error' => 'Não foi possível cancelar o pedido',
                'reverse_success' => 'O valor foi estornado com sucesso.',
                'reverse_value' => 'O valor do estorno não pode ser maior que o valor do pedido',
                'reverse_error' => 'Não foi possível estornar o valor'
            )
        );
    }

    /**
     * Consulta o status do pedido individual
     *
     * @param $id
     * @return View
     */
    public function index($id)
    {
        if( Gate::denies("{$this->ability}-view") ) {
            return view("backend.erros.message-401");
        }

        $order = $this->model->setId($id);
        $content = typeJson($this->content);

        //$status = $this->pagSeguroServices->statusAll($order->code, $order->reference, $order->created_at);

        $response = $this->pagSeguroServices->consultationStatus($order->reference);
        $transaction = typeJson($response->transaction);


        return view("{$this->view}.index", compact(
            'order','content', 'reference', 'transaction')
        );
    }


    /**
     * Cancelar Pedido
     * Status: Aguardando ou Em Análise
     *
     * @param Request $request
     * @return Json
     */
    public function cancelTransaction(Request $request)
    {
        if( Gate::denies("{$this->ability}-view") ) {
            return view("backend.erros.message-401");
        }

        $content = typeJson($this->content);

        $success = false;
        $message = $content->messages->cancel_error;


        $order = $this->model->setId($request->id);


        $message = $content->messages->cancel_error;

        $response = $this->pagSeguroServices->cancelTransaction($order->code);
        if ($response === 'OK') {
            $input = [
                'config_status_payment_id' => 7,
                'status_label' => config("pagseguro.status.7.label")
            ];
            $change = $this->model->changeStatus($input, $order->reference);
            if ($change)
                $success = true;
                $message = $content->messages->cancel_success;
        }

        $out = array(
            'success' => $success,
            'message' => $message,
            'id' => $order->id
        );

        return response()->json($out);

    }


    /**
     * Estornar Pedido
     * Status: Paga, Disponível ou Em disputa.
     *
     * @param Request $request
     * @return Json
     */
    public function ReverseTransaction(Request $request)
    {
        if( Gate::denies("{$this->ability}-view") ) {
            return view("backend.erros.message-401");
        }

        $content = typeJson($this->content);

        $success = false;
        $message = $content->messages->reverse_error;

        $order = $this->model->setId($request->id);
        $value = $request->refundValue;
        if ($value <= $order->total) {
            $response = $this->pagSeguroServices->reverseTransaction($order->code, $value);
            if ($response === 'OK') {
                $input = [
                    'config_status_payment_id' => 6,
                    'status_label' => config("pagseguro.status.6.label")
                ];
                $change = $this->model->changeStatus($input, $order->reference);
                if ($change)
                    $success = true;
                $message = $content->messages->reverse_success;
            }

        } else {
            $message = $content->messages->reverse_value;
        }

        $out = array(
            'success' => $success,
            'message' => $message,
            'id' => $order->id
        );

        return response()->json($out);
    }

}
