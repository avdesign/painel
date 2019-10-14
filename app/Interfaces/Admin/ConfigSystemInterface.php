<?php

namespace AVDPainel\Interfaces\Admin;

interface ConfigSystemInterface
{
    /**
     * Interface model ConfigSystem
     *
     * @return \AVDPainel\Repositories\Admin\ConfigSystemRepository
     */
    public function get();
    public function create($input);
    public function update($input);
}