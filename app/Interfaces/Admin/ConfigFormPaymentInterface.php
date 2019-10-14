<?php

namespace AVDPainel\Interfaces\Admin;

interface ConfigFormPaymentInterface
{
    /**
     * Interface model ConfigFormPayment
     *
     * @return \AVDPainel\Repositories\Admin\ConfigFormPaymentRepository
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