<?php

namespace AVDPainel\Interfaces\Admin;

interface ConfigFreightInterface
{
    /**
     * Interface model ConfigFreight
     *
     * @return \AVDPainel\Repositories\Admin\ConfigFreightRepository
     */
    public function setId($id);
    public function update($input, $id);
    
}