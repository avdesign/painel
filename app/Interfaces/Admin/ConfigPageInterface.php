<?php

namespace AVDPainel\Interfaces\Admin;

interface ConfigPageInterface
{
    /**
     * Interface model ConfigPage
     *
     * @return \AVDPainel\Repositories\Admin\ConfigPageRepository
     */
    public function getAll();
    public function create($input, $message);
    public function setId($id);
    public function update($input, $id, $message);
    public function delete($id, $message);
    public function rules($input, $messages, $id);

}