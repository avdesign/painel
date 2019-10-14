<?php

namespace AVDPainel\Interfaces\Admin;

interface ConfigTemplateInterface
{
    /**
     * Interface model ConfigTemplate
     *
     * @return \AVDPainel\Repositories\Admin\ConfigTemplateRepository
     */
    public function getAll();
    public function setId($id);
    public function create($input, $message);
    public function update($input, $id, $message);
    public function delete($id, $message);
    public function deleteAll($id, $message);
    public function rules($input, $messages, $id);
}