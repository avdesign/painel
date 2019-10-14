<?php

namespace AVDPainel\Interfaces\Admin;

interface ConfigSubjectContactInterface
{
    /**
     * Interface model ConfigSubjectContact
     *
     * @return \AVDPainel\Repositories\Admin\ConfigSubjectContactRepository
     */
    public function getAll();
    public function setId($id);
    public function create($input);
    public function update($input, $id);
    public function delete($id);
    public function rules($input, $messages, $id);
   
}