<?php

namespace AVDPainel\Interfaces\Admin;

interface ConfigPercentInterface
{
    /**
     * Interface model ConfigPercent 
     *
     * @return \AVDPainel\Repositories\Admin\ConfigPercentRepository
     */
    public function get();
    public function getAll($input);
    public function getFilde($filde, $name);
    public function setId($id);
    public function pluck();
    public function create($input);
    public function update($input, $id);
    public function delete($id);
    public function rules($input, $messages, $id);
}