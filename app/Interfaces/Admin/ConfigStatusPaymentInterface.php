<?php

namespace AVDPainel\Interfaces\Admin;

interface ConfigStatusPaymentInterface
{
    /**
     * Interface model ConfigStatusPayment
     *
     * @return \AVDPainel\Repositories\Admin\ConfigStatusPaymentRepository
     */
    public function getAll();
    public function setId($id);
    public function create($input);
    public function update($input, $id);
    public function delete($id);
    public function pluck();
    public function rules($input, $messages, $id);

    //Excluded
    public function getExcluded();
}