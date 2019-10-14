<?php

namespace AVDPainel\Interfaces\Admin;

interface ConfigAdminInterface
{
    /**
     * Interface model ConfigAdmin
     *
     * @return \AVDPainel\Repositories\Admin\ConfigAdminRepository
     */
    public function get($value, $id);
    public function setId($id);
    public function update($input, $id);
    public function rules($input, $messages, $id);
}