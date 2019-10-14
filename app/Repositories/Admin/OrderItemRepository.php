<?php

namespace AVDPainel\Repositories\Admin;


use AVDPainel\Models\Admin\OrderItem as Model;
use AVDPainel\Interfaces\Admin\OrderItemInterface;

use Illuminate\Foundation\Validation\ValidatesRequests;

class OrderItemRepository implements OrderItemInterface
{
    use ValidatesRequests;

    public $model;

    /**
     * Create construct.
     *
     * @return void
     */
    public function __construct(Model $model)
    {
        $this->model = $model;
    }

    /**
     * @param $input
     * @param $messages
     * @param string $id
     */
    public function rules($input, $messages, $id='')
    {
        $this->validate($input, $this->model->rules($id), $messages);
    }

    /**
     * @param $id
     * @return mixed
     */
    public function setId($id)
    {
        return $this->model->find($id);
    }

    /**
     * @param $input
     * @param $order
     * @param $color
     * @param $configProduct
     * @return array
     */
    public function create($input, $order, $color, $configProduct)
    {
        $product = $color->product;
        $prices = $product->prices;
        foreach ($prices as $price) {
            if ($configProduct->config_prices == 1) {
                if ($price->config_profile_client_id == $order->user->profile_id) {
                    if ($product->offer == 1) {
                        $percent = $price->offer_percent;
                        $price_card = $price->offer_card;
                        $price_cash = $price->offer_cash;
                    } else {
                        $percent = $price->price_cash_percent;
                        $price_card = $price->price_card;
                        $price_cash = $price->price_cash;
                    }
                }
            } else {
                if ($product->offer == 1) {
                    $percent = $price->offer_percent;
                    $price_card = $price->offer_card;
                    $price_cash = $price->offer_cash;
                } else {
                    $percent = $price->price_cash_percent;
                    $price_card = $price->price_card;
                    $price_cash = $price->price_cash;
                }
            }
        }

        $item = [
            'order_id' => $order->id,
            'user_id' => $order->user->id,
            'image_color_id' => $color->id,
            'image' => $color->image,
            'color' => $color->color,
            'code' => $color->code,
            'offer' => $product->offer,
            'percent' => $percent,
            'price_card' => $price_card,
            'price_cash' => $price_cash,
            'slug' => $color->slug,
            'kit' => $color->kit,
            'kit_name' => $color->kit_name,
            'name' => $product->name,
            'category' => $product->category,
            'section' => $product->section,
            'brand' => $product->brand,
            'unit' => $product->unit,
            'measure' => $product->measure,
            'weight' => $product->weight,
            'width' => $product->width,
            'height' => $product->height,
            'length' => $product->length,
            'cost' => $product->cost
        ];

        $i=1;
        if ($color->kit == 1) {
            foreach ($input as $value) {
                $grid      = $value['grid'];
                $quantity  = $value['quantity'];
            }
            $item['grid']     = $grid;
            $item['quantity'] = $quantity;
            $exist = $this->model->where(['user_id' => $order->user->id, 'image_color_id' => $color->id, 'grid' => $grid])->first();
            if ($exist) {

                $update = $exist->update($item);
                if ($update) {
                    generateAccessesTxt(
                        date('H:i:s').utf8_decode(
                            ' Alterou o Pedido:'.$order->id.
                            ', Produto:'.$product->name.
                            ', Ref:'.$color->code.
                            ', Cor:'.$color->color.
                            ', '.$grid.
                            ', Qtd:'.$quantity)
                    );
                }

            } else {

                $create = $this->model->create($item);
                if ($create) {
                    generateAccessesTxt(
                        date('H:i:s').utf8_decode(
                            ' Adicionou ao Pedido:'.$order->id.
                            ', Produto:'.$product->name.
                            ', Ref:'.$color->code.
                            ', Cor:'.$color->color.
                            ', '.$grid.
                            ', Qtd:'.$quantity)
                    );
                }

            }

        } else {
            foreach ($input as $value) {
                $item['grid']     = $value['grid'];
                $item['quantity'] = $value['quantity'];

                $exist = $this->model->where(['user_id' => $order->user->id, 'image_color_id' => $color->id, 'grid' => $value['grid']])->first();
                if ($exist) {

                    $update = $exist->update($item);
                    if ($update) {
                        generateAccessesTxt(
                            date('H:i:s').utf8_decode(
                                ' Alterou o Pedido:'.$order->id.
                                ', Produto:'.$product->name.
                                ', Ref:'.$color->code.
                                ', Cor:'.$color->color.
                                ', '.$value['grid'].
                                ', Qtd:'.$value['quantity'])
                        );
                    }

                } else {
                    $create = $this->model->create($item);
                    if ($create) {
                        generateAccessesTxt(
                            date('H:i:s').utf8_decode(
                                ' Adicionou ao pedido:'.$order->id.
                                ', Produto:'.$product->name.
                                ', Ref:'.$color->code.
                                ', Cor:'.$color->color.
                                ', '.$value['grid'].
                                ', Qtd:'.$value['quantity'])
                        );
                    }

                }

                $i++;
            }
        }

        return array('route' => route('order-items.reload', $order->id));
    }


    /**
     * @param $input
     * @param $id
     * @return bool
     */
    public function update($input, $id)
    {
        $data   = $this->model->find($id);
        $update = $data->update($input);
        if ($update) {
            generateAccessesTxt(
                date('H:i:s').utf8_decode(
                    ' Alterou a quantidade do pedido:'.$data->order_id.
                    ', Produto:'.$data->name.
                    ', Ref:'.$data->code.
                    ', Cor:'.$data->color.
                    ', '.$data->grid.
                    ', Qtd:'.$input['quantity'])
            );
            return true;
        }

        return false;
    }


    /**
     * @param $id
     * @return bool
     */
    public function delete($id)
    {
        $data   = $this->model->find($id);
        if ($data->kit == 1) {
            $grade = ', '.$data->kit_name.' '.$data->unit.' '.$data->measure.' Grade:'.$data->grid;
        } else {
            $grade = ', Grade:'.$data->grid;
        }
        $delete = $data->delete();
        if ($delete) {
            generateAccessesTxt(
                date('H:i:s').utf8_decode(
                    ' Excluiu o produto do Pedido:'.$data->order_id.
                    ', Produto:'.$data->name.
                    ', Ref:'.$data->code.
                    ', Cor:'.$data->color.
                    $grade.
                    ', Qtd:'.$data->quantity)
            );

            return $data;
        }

        return false;
    }


}