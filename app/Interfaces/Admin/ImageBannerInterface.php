<?php

namespace AVDPainel\Interfaces\Admin;

interface ImageBannerInterface
{
    /**
     * Interface model ImageBanner
     *
     * @return \AVDPainel\Repositories\Admin\ImageBannerRepository
     */
    public function getAll($type);
    public function setId($id);
    public function create($input, $type, $message);
    public function update($input, $id, $message);
    public function delete($id, $type, $message, $config);
    public function status($id, $message);
    public function getOrder($id);
    public function updateOrder($input, $messages);
    public function rules($input, $messages, $id);
}