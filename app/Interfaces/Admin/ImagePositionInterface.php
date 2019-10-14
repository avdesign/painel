<?php

namespace AVDPainel\Interfaces\Admin;

interface ImagePositionInterface
{
    /**
     * Date 06/04/2019
     *
     * @return \AVDPainel\Repositories\Admin\ImagePositionRepository
     */
    public function get($id);
    public function setId($id);
    public function create($input, $config, $file, $wiew, $action);
    public function update($input, $image, $config, $file, $wiew, $action);
    public function delete($id, $config);
    public function status($config, $input, $wiew, $id);
    
}