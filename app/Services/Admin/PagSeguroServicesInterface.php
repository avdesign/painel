<?php

namespace AVDPainel\Services\Admin;

interface PagSeguroServicesInterface
{
    /**
     * Interface model PagSeguroServices
     *
     * @return \AVDPainel\Services\Admin\PagSeguroServices
     */

    public function getStatusTransaction($notificationCode);
    public function consultationStatus($reference);
    public function cancelTransaction($code);
    public function reverseTransaction($code, $value);

}