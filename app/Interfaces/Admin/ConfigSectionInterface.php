<?php

namespace AVDPainel\Interfaces\Admin;

interface ConfigSectionInterface
{
    /**
     * Interface model ConfigSection
     *
     * @return \AVDPainel\Repositories\Admin\ConfigSectionRepository
     */
    public function get($value, $id);
    public function setId($id);
    public function update($input, $id);
    public function rules($input, $messages, $id);
}