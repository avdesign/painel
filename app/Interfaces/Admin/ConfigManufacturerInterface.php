<?php

namespace AVDPainel\Interfaces\Admin;

interface ConfigManufacturerInterface
{
    /**
     * Interface model ConfigManufacturer
     *
     * @return \AVDPainel\Repositories\Admin\ConfigManufacturerRepository
     */
    public function get($value, $id);
    public function setId($id);
    public function update($input, $id);
    public function rules($input, $messages, $id);
}