<?php

namespace AVDPainel\Interfaces\Admin;

interface OrderInterface
{
    /**
     * Interface model Order
     *
     * @return \AVDPainel\Repositories\Admin\OrderRepository
     */

    public function getAll($request);
    public function getOrder($user_id);
    public function setId($id);
    public function create($input,$status,$form);
    public function update($input, $id);
    public function delete($id);

    //Excluded
    public function getExcluded($request);
    public function reactivate($id);

    public function rules($input, $messages, $id);

    //PagSeguro
    public function changeStatus($input, $reference);


}