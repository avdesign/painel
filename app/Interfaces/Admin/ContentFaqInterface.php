<?php

namespace AVDPainel\Interfaces\Admin;

interface ContentFaqInterface
{
    /**
     * Interface model ContentFaq
     *
     * @return \AVDPainel\Repositories\Admin\ContentFaqRepository
     */
    public function getAll();
    public function setId($id);
    public function create($input, $message);
    public function update($input, $id, $message);
    public function delete($id, $message);
    public function status($id, $message);
    public function getOrder($id);
    public function updateOrder($input, $message);
    public function rules($input, $messages, $id);
   
}