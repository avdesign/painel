<?php

namespace AVDPainel\Interfaces\Admin;

interface StockInterface
{
    /**
     * Date: 03/06/2019
     * uploadImages
     *
     * @return \AVDPainel\Repositories\Admin\StockRepository
     */
    public function setId($id);
    public function getAll($request);
    public function update($configProduct, $input, $id);
    public function existStock($configProduct, $product);

}