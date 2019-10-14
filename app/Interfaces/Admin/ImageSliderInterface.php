<?php

namespace AVDPainel\Interfaces\Admin;

interface ImageSliderInterface
{
    /**
     * Interface model ImageSlider
     *
     * @return \AVDPainel\Repositories\Admin\ImageSliderRepository
     */
    public function getAll($id);
    public function setId($id);
    public function create($input, $id);
    public function update($input, $id, $idfile);
    public function delete($id, $config='');
    public function status($id);
    public function getOrder($id);
    public function updateOrder($input, $messages);
    public function rules($input, $messages, $id);
}