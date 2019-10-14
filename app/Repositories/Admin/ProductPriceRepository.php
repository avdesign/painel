<?php

namespace AVDPainel\Repositories\Admin;

use AVDPainel\Models\Admin\ProductPrice as Model;
use AVDPainel\Interfaces\Admin\ProductPriceInterface;


class ProductPriceRepository implements ProductPriceInterface
{

    public $model;
    public $profileClient;

    /**
     * ProductPriceRepository constructor.
     * @param Model $model
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * Date: 06/15/2019
     *
     * @param $input
     * @param $idpro
     * @param $offer
     * @param $price_default
     * @return mixed
     */
    public function create($input, $idpro, $offer, $price_default)
    {     
        $text_offer_card = '';
        $text_offer_cash = '';
        foreach ($input as $key => $value) {

            ($value['price_cash_percent'] < 0 ? $sum_cash = '-' : $sum_cash = '+');
            ($value['price_card_percent'] < 0 ? $sum_card = '-' : $sum_card = '+');
            
            ($value['profile'] != $price_default ? $value['sum_card'] = $sum_card : $value['sum_card'] = '-');
            ($value['profile'] != $price_default ? $value['sum_cash'] = $sum_cash : $value['sum_cash'] = '-');

            $value['price_cash_percent'] = abs($value['price_cash_percent']);
            $value['price_card_percent'] = abs($value['price_card_percent']);

            $value['product_id'] = $idpro;

            $data = $this->model->create($value);
            if ($data) {
                if ($offer == 1) {
                    $text_offer_card = '- '.constLang('offer').' '.constLang('card').':'.setReal($data->offer_card);
                    $text_offer_cash = ', '.constLang('cash').':'.round($data->offer_percent, 2).'% '.setReal($data->offer_cash);
                }
                if ($data->profile == $price_default) {
                    $price_card_percent = '';
                    $price_cash_percent = round($data->price_cash_percent, 2);
                } else {
                    $price_card_percent = round($data->price_card_percent, 2);
                    $price_cash_percent = round($data->price_cash_percent, 2);
                } 
                generateAccessesTxt(utf8_decode('- '.constLang('value').':'.$data->profile.
                    ', '.constLang('card').':'.$price_card_percent.'% '.setReal($data->price_card).
                    ', '.constLang('cash').':'.$price_cash_percent.'% '.setReal($data->price_cash).
                    ' '.$text_offer_card . $text_offer_cash));

            }
        }

        return $data;        
    }

    /**
     * Date: 06/15/2019
     *
     * @param $input
     * @param $idpro
     * @param $offer
     * @param $price_default
     * @return mixed
     */
    public function update($input, $idpro, $offer, $price_default)
    {

        $text_offer_card = '';
        $text_offer_cash = '';

        foreach ($input as $key => $value) {
            ($value['price_cash_percent'] < 0 ? $sum_cash = '-' : $sum_cash = '+');
            ($value['price_card_percent'] < 0 ? $sum_card = '-' : $sum_card = '+');
            
            ($value['profile'] != $price_default ? $value['sum_card'] = $sum_card : $value['sum_card'] = '-');
            ($value['profile'] != $price_default ? $value['sum_cash'] = $sum_cash : $value['sum_cash'] = '-');

            $value['price_cash_percent'] = abs($value['price_cash_percent']);
            $value['price_card_percent'] = abs($value['price_card_percent']);

            $value['product_id'] = $idpro;

            $data   = $this->model->find($value['id']);

            $update = $data->update($value);

            if ($update) {
                if ($offer == 1) {
                    $text_offer_card = '- '.constLang('offer').' '.constLang('card').':'.setReal($data->offer_card);
                    $text_offer_cash = ', '.constLang('cash').':'.round($data->offer_percent, 2).'% '.setReal($data->offer_cash);
                }
                if ($data->profile == $price_default) {
                    $price_card_percent = '';
                    $price_cash_percent = round($data->price_cash_percent, 2);
                } else {
                    $price_card_percent = round($data->price_card_percent, 2).'% ';
                    $price_cash_percent = round($data->price_cash_percent, 2);
                } 
                generateAccessesTxt(utf8_decode(', '.constLang('profile').':'.$data->profile.
                    ', '.constLang('card').':'.$price_card_percent.setReal($data->price_card).
                    ', '.constLang('cash').':'.$price_cash_percent.'% '.setReal($data->price_cash).
                    ' '.$text_offer_card . $text_offer_cash));
            }
        }

        return $update;     
    }


}