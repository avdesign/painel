<?php

namespace AVDPainel\Interfaces\Admin;

interface ConfigBrandInterface
{
    /**
     * Interface model ConfigBrand
     *
     * @return \AVDPainel\Repositories\Admin\ConfigBrandRepository
     */
    public function get($value, $id);
    public function setId($id);
    public function update($input, $id);
    public function rules($input, $messages, $id);
}