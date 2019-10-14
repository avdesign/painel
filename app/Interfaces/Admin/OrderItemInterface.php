<?php

namespace AVDPainel\Interfaces\Admin;

interface OrderItemInterface
{
    /**
     * Interface model OrderItem
     *
     * @return \AVDPainel\Repositories\Admin\OrderItemRepository
     */
    public function setId($id);
    public function create($input, $order, $color, $configProduct);
    public function update($input, $id);
    public function delete($id);

    public function rules($input, $messages, $id);


}