<?php

namespace AVDPainel\Interfaces\Admin;

interface GridCategoryInterface
{
    /**
     * Interface model GridCategory
     *
     * @return \AVDPainel\Repositories\Admin\GridCategoryRepository
     */
    public function getAll($id);
    public function setId($id);
    public function create($input, $id);
    public function update($input, $id, $idgrid);
    public function delete($id);
    public function rules($input, $messages, $id);
}