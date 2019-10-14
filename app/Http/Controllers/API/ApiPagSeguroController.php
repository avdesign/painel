<?php

namespace AVDPainel\Http\Controllers\API;

use Illuminate\Http\Request;

use AVDPainel\Http\Controllers\Controller;
use AVDPainel\Services\Admin\PagSeguroServicesInterface as InterPagSeguro;
use AVDPainel\Interfaces\Admin\OrderInterface as InterOrder;


class ApiPagSeguroController extends Controller
{
    /**
     * @var InterOrder
     */
    private $interOrder;
    /**
     * @var InterPagSeguro
     */
    private $interPagSeguro;

    public function __construct(
        InterOrder $interOrder,
        InterPagSeguro $interPagSeguro)
    {
        $this->interOrder = $interOrder;
        $this->interPagSeguro = $interPagSeguro;
    }



    public function request(Request $request)
    {
        if (!$request->notificationCode)
            return response()->json(['error' => 'NotNotificationCode'], 404);

        $response =  $this->interPagSeguro->getStatusTransaction($request->notificationCode);

        $imput = [
            'config_status_payment_id' => $response['status'],
            'status_label' => config("pagseguro.status.{$response['status']}.label")
        ];

        $update = $this->interOrder->changeStatus($imput, $response['reference']);

    }
}
