<?php

namespace AVDPainel\Interfaces\Admin;

interface ConfigModuleInterface
{
    /**
     * Interface model ConfigModule
     *
     * @return \AVDPainel\Repositories\Admin\ConfigModuleRepository
     */
    public function get();
    public function getAll($input);
    public function getType($type);
    public function setId($id);
    public function pluck();
    public function create($input);
    public function update($input, $id);
    public function delete($id);
    public function rules($input, $messages, $id);
    public function typeModules($request, $id, $type);

}