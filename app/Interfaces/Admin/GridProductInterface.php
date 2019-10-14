<?php

namespace AVDPainel\Interfaces\Admin;

interface GridProductInterface
{
    /**
     * Interface model GridProduct
     *
     * @return \AVDPainel\Repositories\Admin\GridProductRepository
     */
    public function setId($id);
    public function getGrids($idmg);
    public function createKit($configProduct, $input, $image, $product);
    public function createUnit($configProduct,$input, $image, $product);
    public function addUnit($configProduct, $input, $image, $product, $view);
    public function updateKit($configProduct, $input, $image, $product, $qty, $des);
    public function updateUnit($configProduct,$input, $image, $product, $grid, $view);
    public function deleteKit($configProduct, $image, $product);
    public function deleteUnit($configProduct, $image, $product, $grid);
    public function change($id, $stock, $kit);
}