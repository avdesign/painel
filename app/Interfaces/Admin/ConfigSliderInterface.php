<?php

namespace AVDPainel\Interfaces\Admin;

interface ConfigSliderInterface
{
    /**
     * Interface model ConfigSlider
     *
     * @return \AVDPainel\Repositories\Admin\ConfigSliderRepository
     */
    public function get($value, $id);
    public function setId($id);
    public function update($input, $id);
    public function rules($input, $messages, $id);
}