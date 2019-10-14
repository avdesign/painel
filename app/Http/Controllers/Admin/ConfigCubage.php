<?php

namespace AVDPainel\Http\Controllers\Admin;

use AVDPainel\Http\Controllers\Controller;

class ConfigCubage extends Controller
{
    private $view = 'backend.settings.cubage';

    public function calculate()
    {
        return view("{$this->view}.index");
    }
}
