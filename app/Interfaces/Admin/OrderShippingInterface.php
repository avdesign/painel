<?php

namespace AVDPainel\Interfaces\Admin;

interface OrderShippingInterface
{
    /**
     * Interface model OrderShipping
     *
     * @return \AVDPainel\Repositories\Admin\OrderShippingRepository
     */

    public function setId($id);
    public function create($input);
    public function update($input, $id);
    // Orders
    public function countNotes($id);

    public function rules($input, $messages, $id);


}