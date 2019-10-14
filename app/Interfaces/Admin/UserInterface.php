<?php

namespace AVDPainel\Interfaces\Admin;

interface UserInterface
{
    /**
     * Interface model User
     *
     * @return \AVDPainel\Repositories\Admin\UserRepository
     */
    public function get();
    public function pluck();
    public function getAll($request);
    public function setId($id);
    public function create($input);
    public function update($input, $id);
    public function delete($id);

    //Create Order
    public function createOrder($id);

    //Excluded
    public function getExcluded($request);
    public function reactivate($id);

    // Wislist
    public function updateAdmin($input, $id);
    public function countAdmin($name);

}