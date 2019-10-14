<?php

namespace AVDPainel\Interfaces\Admin;

interface ConfigKeywordInterface
{
    /**
     * Interface model ConfigKeyword
     *
     * @return \AVDPainel\Repositories\Admin\ConfigKeywordRepository
     */
    public function get();
    public function getAll($input);
    public function setId($id);
    public function rand($fild);
    public function create($input);
    public function update($input, $id);
    public function delete($id);
    public function rules($input, $messages, $id);


}