<?php

namespace AVDPainel\Interfaces\Admin;

interface GridSectionInterface
{
    /**
     * Interface model GridSection
     *
     * @return \AVDPainel\Repositories\Admin\GridSectionRepository
     */
    public function getAll($id);
    public function setId($id);
    public function create($input, $id);
    public function update($input, $id, $idgrid);
    public function delete($id);
    public function rules($input, $messages, $id);
}