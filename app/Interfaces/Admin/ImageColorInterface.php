<?php

namespace AVDPainel\Interfaces\Admin;

interface ImageColorInterface
{
    /**
     * Date: 03/06/2019
     * uploadImages
     *
     * @return \AVDPainel\Repositories\Admin\ImageColorRepository
     */
    public function get($id);
    public function setId($id);
    public function getAll($request);
    public function create($input, $product, $config);
    public function update($input, $config, $product, $image);
    public function delete($image, $product, $config, $reload);
    public function status($input, $product, $view, $id);
    public function uploadImages($config, $input, $image, $product, $file);
    public function uploadRender($config, $image, $action, $code);
    // All Colors
    public function colorsStatus($input, $product, $id);
    // Search Products Wishlist/Orders
    function search($request, $mod_id, $route);


}