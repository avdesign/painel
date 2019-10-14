<?php

namespace AVDPainel\Interfaces\Admin;

interface CategoryInterface
{
    /**
     * Interface model Category
     *
     * @return \AVDPainel\Repositories\Admin\CategoryRepository
     */
    public function get();
    public function getAll($input);
    public function setId($id);
    public function setName($field, $name);
    public function create($input);
    public function update($input, $id);
    public function delete($id, $config, $configImages);
    public function rules($input, $messages, $id);

}