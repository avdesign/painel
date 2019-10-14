<?php

namespace AVDPainel\Repositories\Admin;

use AVDPainel\Models\Admin\ProductCost as Model;
use AVDPainel\Interfaces\Admin\ProductCostInterface;


class ProductCostRepository implements ProductCostInterface
{

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
     * Date: 06/02/2019
     *
     * @param $input
     * @param $product
     * @return mixed
     */
    public function create($input, $product)
    {
        $input['product_id'] = $product->id;

        $data = $this->model->create($input);
        if ($data) {
            generateAccessesTxt('- '.constLang('cost').':'.setReal($data->value));
        }

        return $data;        
    }

    /**
     * Date: 06/02/2019
     *
     * @param $input
     * @param $product
     * @return mixed
     */
    public function update($input, $product)
    {
        $cost   = $product->cost;
        $data   = $this->model->find($cost->id);

        $update = $data->update($input);

        if ($update) {
            generateAccessesTxt('- '.constLang('cost').':'.setReal($input['value']));
        }
        return $update;     
    }


}