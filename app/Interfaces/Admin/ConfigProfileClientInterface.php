<?php

namespace AVDPainel\Interfaces\Admin;

interface ConfigProfileClientInterface
{
    /**
     * Interface model ConfigProfileClient 
     *
     * @return \AVDPainel\Repositories\Admin\ConfigProfileClientRepository
     */
    public function get();
    public function getAll($input);
    public function getFild($fild, $name);
    public function setId($id);
    public function setDefault();
    public function pluck();
    public function create($input);
    public function update($input, $id);
    public function delete($id);
    public function rules($input, $messages, $id);
}