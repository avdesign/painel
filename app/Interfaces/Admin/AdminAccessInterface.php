<?php

namespace AVDPainel\Interfaces\Admin;

interface AdminAccessInterface
{
    /**
     * Interface model AdminAccess
     *
     * @return \AVDPainel\Repositories\Admin\AdminAccessRepository
     */
    public function setUser($id);
    public function create($input);
    public function update($input);
}