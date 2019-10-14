<?php

namespace AVDPainel\Repositories\Admin;


use AVDPainel\Models\Admin\State as Model;
use AVDPainel\Interfaces\Admin\StateInterface;

use Illuminate\Foundation\Validation\ValidatesRequests;

class StateRepository implements StateInterface
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

    public function pluck($name, $id)
    {
        return $this->model->pluck($name,$id);
    }

}