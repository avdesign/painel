<?php

namespace AVDPainel\Interfaces\Admin;

interface ConfigSiteInterface
{
    /**
     * Interface model ConfigSite
     *
     * @return \AVDPainel\Repositories\Admin\ConfigSiteRepository
     */
    public function get($value, $id);
    public function setId($id);
    public function update($input, $id);
}