<?php

namespace AVDPainel\Interfaces\Admin;

interface GridBrandInterface
{
    /**
     * Interface model GridBrand
     *
     * @return \AVDPainel\Repositories\Admin\GridBrandRepository
     */
    public function getAll($id);
    public function setId($id);
    public function create($input, $id);
    public function update($input, $id, $idgrid);
    public function delete($id);
    public function rules($input, $messages, $id);
}