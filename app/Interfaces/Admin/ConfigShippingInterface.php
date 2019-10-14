<?php

namespace AVDPainel\Interfaces\Admin;

interface ConfigShippingInterface
{
    /**
     * Interface model ConfigShipping
     *
     * @return \AVDPainel\Repositories\Admin\ConfigShippingRepository
     */
    public function getAll();
    public function setId($id);
    public function pluck($name, $id);
    public function create($input);
    public function update($input, $id);
    public function delete($id);
    public function rules($input, $messages, $id);
}