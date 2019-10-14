<?php
namespace AVDPainel\Interfaces\Admin;

interface UserAddressInterface
{
    /**
     * Interface model UserAddress
     *
     * @return \AVDPainel\Repositories\Admin\UserAddressRepository
     */
    public function setId($id);
    public function create($input);
    public function update($input, $id);


}