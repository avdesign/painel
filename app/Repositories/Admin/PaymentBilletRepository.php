<?php

namespace AVDPainel\Repositories\Admin;


use AVDPainel\Models\Admin\PaymentBillet as Model;
use AVDPainel\Interfaces\Admin\PaymentBilletInterface;


class PaymentBilletRepository implements PaymentBilletInterface
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
     * Create
     *
     * @param  array $input
     * @return mixed
     */
    public function create($input)
    {
        return $this->model->create($input);
    }


}