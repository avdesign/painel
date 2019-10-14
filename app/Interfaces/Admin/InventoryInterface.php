<?php

namespace AVDPainel\Interfaces\Admin;

interface InventoryInterface
{
    /**
     * Interface model Inventory
     *
     * @return \AVDPainel\Repositories\Admin\InventoryRepository
     */
    public function getAll($request);
    public function setId($id);

}