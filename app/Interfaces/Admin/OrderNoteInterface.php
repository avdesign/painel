<?php

namespace AVDPainel\Interfaces\Admin;

interface OrderNoteInterface
{
    /**
     * Interface model OrderNote
     *
     * @return \AVDPainel\Repositories\Admin\OrderNoteRepository
     */

    public function setId($id);
    public function create($input);
    public function update($input, $id);

    // Orders
    public function countNotes($id);

    public function rules($input, $messages, $id);


}