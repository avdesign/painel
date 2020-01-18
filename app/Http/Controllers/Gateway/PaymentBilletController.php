<?php

namespace AVDPainel\Http\Controllers\Gateway;

use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Date;

use OpenBoleto\Agente;
use OpenBoleto\Banco\Itau;

use AVDPainel\Http\Controllers\Controller;

use AVDPainel\Interfaces\Admin\OrderInterface as InterOrder;
use AVDPainel\Interfaces\Admin\OrderNoteInterface as InterOrderNote;
use AVDPainel\Interfaces\Admin\OrderItemInterface as InterOrderItems;
use AVDPainel\Interfaces\Admin\PaymentBilletInterface as InterBillet;
use AVDPainel\Interfaces\Admin\OrderShippingInterface as InterOrderShipping;

class PaymentBilletController extends Controller
{
    /**
     * @var InterOrder
     */
    private $interOrder;
    /**
     * @var InterBillet
     */
    private $interBillet;
    /**
     * @var InterOrderNote
     */
    private $interOrderNote;
    /**
     * @var InterOrderItems
     */
    private $interOrderItems;
    /**
     * @var InterOrderShipping
     */
    private $interOrderShipping;


    public function __construct(
        InterOrder $interOrder,
        InterBillet $interBillet,
        InterOrderNote $interOrderNote,
        InterOrderItems $interOrderItems,
        InterOrderShipping $interOrderShipping)
    {

        $this->interOrder = $interOrder;
        $this->interBillet = $interBillet;
        $this->interOrderNote = $interOrderNote;
        $this->interOrderItems = $interOrderItems;
        $this->interOrderShipping = $interOrderShipping;
    }


    /**
     * Generate Billet
     *
     * @param  $reference
     */
    public function generateBillet($reference)
    {
        $order   = $this->interOrder->setReference($reference);
        if (!$order) {
            return response()->redirectTo(route('home'));
        }
        $sacado  = $this->sacado($order->user);
        $cedente = $this->cedente();
        $numeroDocumento = substr($order->reference, -7);
        $sequencial = str_pad(($order->id), 8, '0', STR_PAD_LEFT);
        $data = date('Ymd Hs');
        $dataVencimento = date('Y-m-d', strtotime("+3 days",strtotime($data)));

        $boleto = new Itau(array(
            // Parâmetros obrigatórios
            'dataVencimento' => new \DateTime($dataVencimento),
            'valor' => $order->total,
            'sequencial' => $sequencial, // 8 dígitos (identificador do campo "id" que você cadastrou no banco de dados, prenchido com zeros a esquerda).
            'sacado' => $sacado,
            'cedente' => $cedente,
            'agencia' => config('company.bank_agency_number'), // 4 dígitos
            'carteira' => config('company.bnank_wallet'), // 3 dígitos
            'conta' => config('company.bank_account_number'), // 5 dígitos

            // Parâmetro obrigatório somente se a carteira for
            // 107, 122, 142, 143, 196 ou 198
            'codigoCliente' => config('company.bank_account_number'), // 5 dígitos
            'numeroDocumento' => $numeroDocumento, // 7 dígitos
            'contaDv' => config('company.bank_account_digit'),
            'agenciaDv' => config('company.bank_agency_digit'),
            'descricaoDemonstrativo' => array( // Até 5
                'Compra de materiais cosméticos',
                'Compra de alicate',
            ),
            'instrucoes' => array( // Até 8
                '- Sr. Caixa, não receber após o vencimento.',
                '- Pedido pelo site: '.config('company.site'),
                '- Em caso de dúvidas entre em contato conosco: '.config('company.phone')

            ),
            // Parâmetros opcionais
            //'resourcePath' => '../resources',
            //'moeda' => Itau::MOEDA_REAL,
            //'dataDocumento' => new DateTime(),
            'dataProcessamento' => new \DateTime(),
            //'contraApresentacao' => true,
            //'pagamentoMinimo' => 23.00,
            //'aceite' => 'N',
            'especieDoc' => 'Pedido',
            //'usoBanco' => 'Uso banco',
            //'layout' => 'layout.phtml',
            //'logoPath' => 'http://saoroque.test/themes/images/logo-white.png',
            //'sacadorAvalista' => new Agente('Antônio da Silva', '02.123.123/0001-11'),
            //'descontosAbatimentos' => 123.12,
            //'moraMulta' => 123.12,
            //'outrasDeducoes' => 123.12,
            //'outrosAcrescimos' => 123.12,
            'valorCobrado' => $order->total,
            'valorUnitario' => $order->total,
            'quantidade' => 1,
        ));

        return $boleto->getOutput();
    }



    public function sacado($user)
    {
        $add = $user->adresses()->orderBy('id', 'desc')->first();

        $sacado = new Agente(
            $user->first_name,
            $user->document1,
            $add->address.', '.$add->number.' '.$add->complement,
            $add->zip_code,
            $add->district.' - '.$add->city,
            $add->state
        );
        return $sacado;
    }


    public function cedente()
    {
        $cedente = new Agente(
            config('company.name'),
            config('company.document1'),
            config('company.address').' - '.config('company.distric'),
            config('company.zip_code'),
            config('company.city'),
            config('company.state')
        );

        return $cedente;
    }
}
