<?php

use Illuminate\Database\Seeder;
use AVDPainel\Models\Admin\ConfigBox;

class ConfigBoxTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        ConfigBox::create([
            'width' => 42,
            'height' => 30,
            'length' => 64
        ]);

        ConfigBox::create([
            'width' => 27,
            'height' => 31,
            'length' => 50
        ]);

        ConfigBox::create([
            'width' => 20,
            'height' => 28,
            'length' => 43
        ]);

    }
}
