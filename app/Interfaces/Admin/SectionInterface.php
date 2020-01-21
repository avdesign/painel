<?php

namespace AVDPainel\Interfaces\Admin;

interface SectionInterface
{
    /**
     * Interface model Section
     *
     * @return \AVDPainel\Repositories\Admin\SectionRepository
     */
    public function get();
    public function getAll($input);
    public function pluck($name, $id);
    public function setId($id);
    public function create($input);
    public function update($input, $id);
    public function delete($data, $products, $config, $configImages);
    public function rules($input, $messages, $id);

}