<?php

namespace AVDPainel\Services\Admin;


use GuzzleHttp\Client as Guzzle;

use AVDPainel\Traits\PagSeguroTrait;



class PagSeguroServices implements PagSeguroServicesInterface
{

    use PagSeguroTrait;



    public function getStatusTransaction($notificationCode)
    {

        $configs = $this->getConfigs();
        $params = http_build_query($configs);



        $guzzle = new Guzzle();
        $response = $guzzle->request('GET', config('pagseguro.url_notification')."/{$notificationCode}", [
            'query' => $params,
        ]);

        $statusCode = $response->getStatusCode();
        $body = $response->getBody();

        $contents = $body->getContents(); //receber code para redirecionar o usuário
        $xml = simplexml_load_string($contents); // xml para json


        return [
            'status' => (string) $xml->status,
            'reference' => (string) $xml->reference
        ];

    }



    public function consultationStatus($reference)
    {
        $configs = $this->getConfigs();

        $params = [
            'reference' => $reference
        ];
        $params = array_merge($configs, $params);

        $params = http_build_query($params);

        $guzzle = new Guzzle();
        $response = $guzzle->request('GET', config('pagseguro.url_consultation_status'), [
            'query' => $params,
        ]);

        $statusCode = $response->getStatusCode();

        $body = $response->getBody();
        $contents = $body->getContents(); //receber code para redirecionar o usuário
        $xml = simplexml_load_string($contents); // xml para json


        return $xml->transactions;

    }



    /**
     * Cancelar Transação
     *
     * @param $code
     * @return string
     */
    public function cancelTransaction($code)
    {
        $configs = $this->getConfigs();
        $params = [
            'transactionCode' => $code
        ];
        $params = array_merge($configs, $params);

        $guzzle = new Guzzle();
        $response = $guzzle->request('POST', config('pagseguro.url_cancel_transaction'), [
            'form_params' => $params,
        ]);

        $statusCode = $response->getStatusCode(); //200 OK
        $body = $response->getBody();
        $contents = $body->getContents();
        $xml = simplexml_load_string($contents);

        return (string)$xml[0];
    }


    /**
     * Estornar Transação
     *
     * @param $code
     * @return string
     */
    public function reverseTransaction($code, $value)
    {
        $configs = $this->getConfigs();
        $params = [
            'transactionCode' => $code,
            'refundValue' => $value
        ];
        $params = array_merge($configs, $params);

        $guzzle = new Guzzle();
        $response = $guzzle->request('POST', config('pagseguro.url_reverse_transaction'), [
            'form_params' => $params,
        ]);

        $statusCode = $response->getStatusCode(); //200 OK
        $body = $response->getBody();
        $contents = $body->getContents();
        $xml = simplexml_load_string($contents);

        return (string)$xml[0];
    }

}