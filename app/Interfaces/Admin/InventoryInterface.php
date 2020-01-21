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
    public function createKit($configProduct, $grids, $image, $product);
    public function updateKit($configProduct, $data, $image, $product, $entry);
    public function deleteKit($configProduct, $product, $image, $grid);
    public function createUnit($configProduct, $grids, $image, $product);
    public function updateUnit($configProduct, $grid, $image, $product, $action);
    public function deleteUnit($configProduct, $product, $image, $grid);
    public function updateStock($configProduct, $grid, $image, $product, $input);
}