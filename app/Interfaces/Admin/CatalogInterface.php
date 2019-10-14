<?php

namespace AVDPainel\Interfaces\Admin;

interface CatalogInterface
{
    /**
     * Date: 03/06/2019
     * uploadImages
     *
     * @return \AVDPainel\Repositories\Admin\CatalogRepository
     */
    public function setId($id);
    public function getAll($request);
    public function status($input, $product, $view, $image);
    // Search Products Wishlist/Orders
    function search($request, $mod_id, $route);


}