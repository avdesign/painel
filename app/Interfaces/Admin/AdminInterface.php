<?php

namespace AVDPainel\Interfaces\Admin;

interface AdminInterface
{
    /**
     * Interface model Admin 
     *
     * @return \AVDPainel\Repositories\Admin\AdminRepository
     */
    public function get();
    public function getAll($input);
    public function setId($id);
    public function setIdExcluded($id);
    public function pluck();
    public function create($input);
    public function update($input, $id);
    public function delete($id);
    public function updateProfile($input, $id);   

    /**
    * Profiles excluded
    */
    public function deleteProfile($name);
    /**
    * Users excluded
    */
    public function excluded($input);
    public function reactivate($id);

}