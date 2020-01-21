<?php

namespace AVDPainel\Interfaces\Admin;

interface BrandInterface
{
    /**
     * Interface model Brand
     *
     * @return \AVDPainel\Repositories\Admin\BrandRepository
     */
    public function get();
    public function pluck();
    public function getAll($input);
    public function setId($id);
    public function create($input);
    public function update($input, $id);
    public function delete($data, $products, $config, $configImages);
    public function rules($input, $messages, $id);

}