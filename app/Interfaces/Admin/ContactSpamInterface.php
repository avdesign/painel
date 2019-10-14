<?php

namespace AVDPainel\Interfaces\Admin;

interface ContactSpamInterface
{
    /**
     * Interface model ContactSpam
     *
     * @return \AVDPainel\Repositories\Admin\ContactSpamRepository
     */
    public function get();
    public function getAll($input);
    public function setId($id);
    public function create($input);
    public function update($input, $id);
    public function delete($id);

    public function rules($input, $messages, $id);
}