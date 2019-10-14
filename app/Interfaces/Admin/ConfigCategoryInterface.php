<?php

namespace AVDPainel\Interfaces\Admin;

interface ConfigCategoryInterface
{
    /**
     * Interface model ConfigCategory
     *
     * @return \AVDPainel\Repositories\Admin\ConfigCategoryRepository
     */
    public function get($value, $id);
    public function setId($id);
    public function update($input, $id);
    public function rules($input, $messages, $id);
}