<?php

namespace AVDPainel\Interfaces\Admin;

interface ImageCategoryInterface
{
    /**
     * Interface model ImageCategory
     *
     * @return \AVDPainel\Repositories\Admin\ImageCategoryRepository
     */
    public function getAll($id);
    public function setId($id);
    public function create($input, $id);
    public function update($input, $id, $idfile);
    public function delete($id, $config='');
    public function status($id);
    public function rules($input, $messages, $id);
}