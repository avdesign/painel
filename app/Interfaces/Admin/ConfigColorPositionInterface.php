<?php

namespace AVDPainel\Interfaces\Admin;

interface ConfigColorPositionInterface
{
    /**
     * Interface model ConfigColorPosition
     *
     * @return \AVDPainel\Repositories\Admin\ConfigColorPositionRepository
     */
    public function get();
    public function getAll($input);
    public function setId($id);
    public function setName($field, $name);
    public function create($input);
    public function update($input, $id);
    public function delete($id);

    public function rules($input, $messages, $id);
}