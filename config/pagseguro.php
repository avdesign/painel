<?php

$environment = env('PAGSEGURO_ENVORINMENT');
$isSandbox = ($environment == 'sandbox') ? true : false;

#urls redirect
$urlCheckout                = ($isSandbox) ? 'https://ws.sandbox.pagseguro.uol.com.br/v2/checkout' : 'https://ws.pagseguro.uol.com.br/v2/checkout';
$urlCheckoutAfterRequest    = ($isSandbox) ? 'https://sandbox.pagseguro.uol.com.br/v2/checkout/payment.html?code=' : 'https://ws.pagseguro.uol.com.br/v2/checkout/payment.html?code=';
# urls lightbox
$urlLightbox                = ($isSandbox) ? 'https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js' : 'https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.lightbox.js';

$urlSessionTranparent       = ($isSandbox) ? 'https://ws.sandbox.pagseguro.uol.com.br/v2/sessions' : 'https://ws.pagseguro.uol.com.br/v2/sessions';
$urlTransparentJs           = ($isSandbox) ? 'https://stc.sandbox.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js' : 'https://stc.pagseguro.uol.com.br/pagseguro/api/v2/checkout/pagseguro.directpayment.js';
$urlPaymentTransparent      = ($isSandbox) ? 'https://ws.sandbox.pagseguro.uol.com.br/v2/transactions' : 'https://ws.pagseguro.uol.com.br/v2/transactions';
$urlNotification            = ($isSandbox) ? 'https://ws.sandbox.pagseguro.uol.com.br/v3/transactions/notifications' : 'https://ws.pagseguro.uol.com.br/v3/transactions/notifications';
$urlConsultationStatus      = ($isSandbox) ? 'https://ws.sandbox.pagseguro.uol.com.br/v2/transactions' : 'https://ws.pagseguro.uol.com.br/v3/transactions';
$urlCancelTransaction       = ($isSandbox) ? 'https://ws.sandbox.pagseguro.uol.com.br/v2/transactions/cancels' : 'https://ws.pagseguro.uol.com.br/v2/transactions/cancels';
$urlReverseTransaction      = ($isSandbox) ? 'https://ws.sandbox.pagseguro.uol.com.br/v2/transactions/refunds' : 'https://ws.pagseguro.uol.com.br/v2/transactions/refunds';

return [
    'environment'   => $environment,
    'email'         => env('PAGSEGURO_EMAIL'),
    'token'         => env('PAGSEGURO_TOKEN'),

    'url_checkout'                  => $urlCheckout,
    'url_redirect_after_request'    => $urlCheckoutAfterRequest,
    'url_lightbox'                  => $urlLightbox,
    'url_transparent_session'       => $urlSessionTranparent,
    'url_transparent_js'            => $urlTransparentJs,
    'url_payment_transparent'       => $urlPaymentTransparent,
    'url_notification'              => $urlNotification,
    'url_consultation_status'       => $urlConsultationStatus,
    'url_cancel_transaction'        => $urlCancelTransaction,
    'url_reverse_transaction'       => $urlReverseTransaction,

    'status' => [
        1 => [
            'label' => 'Aguardando',
            'description' => 'O comprador iniciou a transação, mas até o momento o PagSeguro não recebeu nenhuma informação sobre o pagamento. Quando a resposta da instituição financeira é muito rápida, omitimos esta notificação.'
        ],
        2 => [
            'label' => 'Em análise',
            'description' => 'O comprador optou por pagar com um cartão de crédito e o PagSeguro está analisando o risco da transação.'
        ],
        3 => [
            'label' => 'Paga',
            'description' => 'A transação foi paga pelo comprador e o PagSeguro já recebeu uma confirmação da instituição financeira responsável pelo processamento. Quando uma transação tem seu status alterado para Paga, isso significa que você já pode liberar o produto vendido ou prestar o serviço contratado. Porém, note que o valor da transação pode ainda não estar disponível para retirada de sua conta, pois o PagSeguro pode esperar o fim do prazo de liberação da transação.'
        ],
        4 => [
            'label' => 'Disponível',
            'description' => 'A transação foi paga e chegou ao final de seu prazo de liberação sem ter sido retornada e sem que haja nenhuma disputa aberta. Este status indica que o valor da transação está disponível para saque.'
        ],
        5 => [
            'label' => 'Em disputa',
            'description' => 'O comprador, dentro do prazo de liberação da transação, abriu uma disputa. A disputa é um processo iniciado pelo comprador para indicar que não recebeu o produto ou serviço adquirido, ou que o mesmo foi entregue com problemas.'
        ],
        6 => [
            'label' => 'Devolvida',
            'description' => 'O valor da transação foi devolvido para o comprador. Se você não possui mais o produto vendido em estoque, ou não pode por alguma razão prestar o serviço contratado, você pode devolver o valor da transação para o comprador. Esta também é a ação tomada quando uma disputa é resolvida em favor do comprador. Transações neste status não afetam o seu saldo no PagSeguro, pois não são nem um crédito e nem um débito.'
        ],
        7 => [
            'label' => 'Cancelada',
            'description' => 'A transação foi cancelada sem ter sido finalizada. Quando o comprador opta por pagar com débito online ou boleto bancário e não finaliza o pagamento, a transação assume este status. Isso também ocorre quando o comprador escolhe pagar com um cartão de crédito e o pagamento não é aprovado pelo PagSeguro ou pela operadora.'
        ],
        8 => [
            'label' => 'Debitado',
            'description' => 'A valor da transação foi devolvido para o comprador.'
        ],
        9 => [
            'label' => 'Retenção',
            'description' => 'O comprador abriu uma solicitação de chargeback junto à operadora do cartão de crédito.'
        ]
    ],


    'testes' => [
        'senha' => 'yrplHgtLv3l18DnW',
        'bandeira' => 'VISA',
        'numero' => '4111111111111111',
        'data' => '12/2030',
        'cvv' => '123',
    ]

];