<?php
namespace AVDPainel\Interfaces\Admin;

interface UserNoteInterface
{
    /**
     * Interface model UserNote
     *
     * @return \AVDPainel\Repositories\Admin\UserNoteRepository
     */
    public function setId($id);
    public function create($input);
    public function update($input, $id);
    public function delete($id);


}