<?php

namespace AVDPainel\Interfaces\Admin;

interface ConfigBannerInterface
{
    /**
     * Interface model ConfigBanner
     *
     * @return \AVDPainel\Repositories\Admin\ConfigBannerRepository
     */
    public function get($value, $id);
    public function setId($id);
    public function update($input, $id);
    public function rules($input, $messages, $id);
}