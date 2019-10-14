<?php

use Illuminate\Database\Seeder;
use AVDPainel\Models\Admin\ConfigManufacturer;

class ConfigManufacturerTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = date('Y-m-d H:i:s');
        ConfigManufacturer::create([
            'info' => 1,
            'grids' => 1,
            'description' => 1,
            'img_default' => 'D',
            'img_logo' => 1,
            'width_logo' => 200,
            'height_logo' => 200,
            'img_banner' => 1,
            'width_banner' => 1900,
            'height_banner' => 350,
            'created_at' => $date
        ]);
    }
}
