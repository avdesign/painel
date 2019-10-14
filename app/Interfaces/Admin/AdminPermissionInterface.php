<?php

namespace AVDPainel\Interfaces\Admin;

interface AdminPermissionInterface
{
    /**
     * Interface model AdminPermission 
     *
     * @return \AVDPainel\Repositories\Admin\AdminPermissionRepository
     */
    public function get();
    public function getAll($input);
    public function getFild($fild, $name);
    public function set($id);
    public function create($input);
    public function update($input, $id);
    public function delete($id);
    public function deleteAdmin($id);

    /**
    * AdminController
    */
    public function getUsers($mod, $user);
    public function updatePermiison($action, $profile, $user, $perm, $mode);

}