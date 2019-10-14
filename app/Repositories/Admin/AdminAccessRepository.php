<?php

namespace AVDPainel\Repositories\Admin;


use AVDPainel\Models\Admin\AdminAccess as Model;
use AVDPainel\Interfaces\Admin\AdminAccessInterface;

use Illuminate\Support\Facades\Auth;

class AdminAccessRepository implements AdminAccessInterface
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

    public function setUser($id)
    {
        $data = $this->model->where('admin_id', $id)->first();
        return $data;
    }

    /**
     * Create
     *
     * @return void
     */
    public function create($input)
    {
        return $this->model->create($input);
    }

    /**
     * Se for no login adiciona +1 access
     * 
     * @@param array $input
     * @return void
     */
    public function update($input)
    {
        $id    = Auth::guard('admin')->id();
        $data  = $this->model->where('admin_id', $id)->first();
        
        if (isset($input['login'])) {
            $input['qty_visits'] = $data->access +1;
        }

        $update = $data->update($input);
    }


}