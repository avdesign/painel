<?php

namespace AVDPainel\Interfaces\Admin;

interface ProductPriceInterface
{
    /**
     * Interface model ProductPrice
     *
     * @return \AVDPainel\Repositories\Admin\ProductPriceRepository
     */
    public function create($input, $idpro, $offer, $price_default);
    public function update($input, $idpro, $offer, $price_default);
}