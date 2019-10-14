<?php

namespace AVDPainel\Interfaces\Admin;

interface StateInterface
{
    /**
     * Interface model State
     *
     * @return \AVDPainel\Repositories\Admin\StateRepository
     */
    public function pluck($name, $id);

}