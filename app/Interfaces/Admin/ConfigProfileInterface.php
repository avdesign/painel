<?php

namespace AVDPainel\Interfaces\Admin;

interface ConfigProfileInterface
{
    /**
     * Interface model ConfigProfile 
     *
     * @return \AVDPainel\Repositories\Admin\ConfigProfileRepository
     */
    public function get();
    public function getAll($input);
    public function getFild($filde, $name);
    public function setId($id);
    public function pluck();
    public function create($input);
    public function update($input, $id);
    public function delete($id);
    public function rules($input, $messages, $id);

    // Users
    public function addUsers($input, $id);
    public function removeUser($id, $iduser, $name);
}