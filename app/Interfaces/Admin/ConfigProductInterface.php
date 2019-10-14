<?php

namespace AVDPainel\Interfaces\Admin;

interface ConfigProductInterface
{
    /**
     * Interface model ConfigProduct
     *
     * @return \AVDPainel\Repositories\Admin\ConfigProductRepository
     */
    public function get($value, $id);
    public function setId($id);
    public function update($input, $id);
}