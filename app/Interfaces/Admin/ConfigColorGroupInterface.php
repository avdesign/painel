<?php

namespace AVDPainel\Interfaces\Admin;

interface ConfigColorGroupInterface
{
    /**
     * Interface model ConfigColorGroup
     *
     * @return \AVDPainel\Repositories\Admin\ConfigColorGroupRepository
     */
    public function getAll();
    public function setId($id);
    public function create($input);
    public function update($input, $id);
    public function delete($id);
    public function rules($input, $messages, $id);

}