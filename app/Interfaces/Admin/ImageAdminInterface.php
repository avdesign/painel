<?php

namespace AVDPainel\Interfaces\Admin;

interface ImageAdminInterface
{
    /**
     * Interface model ImageAdmin
     *
     * @return \AVDPainel\Repositories\Admin\ImageAdminRepository
     */
    public function getAll($id);
    public function setId($id);
    public function create($input, $id);
    public function update($input, $id, $idfile);
    public function delete($id, $config='');
    public function deleteExcluded($id, $admin, $config);
    public function status($id);
    public function rules($input, $messages, $id);
}