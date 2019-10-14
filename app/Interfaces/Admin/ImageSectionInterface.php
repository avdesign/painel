<?php

namespace AVDPainel\Interfaces\Admin;

interface ImageSectionInterface
{
    /**
     * Interface model ImageSection
     *
     * @return \AVDPainel\Repositories\Admin\ImageSectionRepository
     */
    public function getAll($id);
    public function setId($id);
    public function create($input, $id);
    public function update($input, $id, $idfile);
    public function delete($id, $config='');
    public function status($id);
    public function rules($input, $messages, $id);
}