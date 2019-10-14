<?php

namespace AVDPainel\Interfaces\Admin;

interface ProductCostInterface
{
    /**
     * Interface model ProductCost
     *
     * @return \AVDPainel\Repositories\Admin\ProductCostRepository
     */
    public function create($input, $product);
    public function update($input, $product);
}