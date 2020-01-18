<?php

namespace AVDPainel\Interfaces\Admin;

interface PaymentBilletInterface
{
    /**
     * Interface model PaymentBillet
     *
     * @return \AVD\Repositories\Admin\PaymentBilletRepository
     */
    public function create($input);

}