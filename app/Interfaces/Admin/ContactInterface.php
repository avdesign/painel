<?php

namespace AVDPainel\Interfaces\Admin;

interface ContactInterface
{
    /**
     * Interface model Contact
     *
     * @return \AVDPainel\Repositories\Admin\ContactRepository
     */
    public function get();
    public function getAll($input);
    public function setId($id);
    public function create($input);
    public function response($input, $id);
    public function status($input, $id);
    public function delete($id);
    public function rules($input, $messages, $id);
}