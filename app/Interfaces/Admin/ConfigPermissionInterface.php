<?php

namespace AVDPainel\Interfaces\Admin;

interface ConfigPermissionInterface
{
    /**
     * Interface model ConfigPermission
     *
     * @return \AVDPainel\Repositories\Admin\ConfigPermissionRepository
     */
    public function get();
    public function getAll($input);
    public function setId($id);
    public function create($input);
    public function update($input, $id);
    public function delete($id);
    public function rules($input, $messages, $id);

    //Profiles
    public function addProfile($input, $id);
    public function delProfile($id, $idpro, $name);
}