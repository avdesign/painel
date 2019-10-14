<?php

use Illuminate\Database\Seeder;
use AVDPainel\Models\Admin\ConfigBrand;

class ConfigBrandTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = date('Y-m-d H:i:s');
        $this->deleteAllPhotosInProductPath();

        ConfigBrand::create([
            'info' => 1,
            'grids' => 1,
            'description' => 1,
            'img_default' => 'D',
            'path' => 'images/brands/',
            'img_logo' => 1,
            'width_logo' => 250,
            'height_logo' => 70,
            'img_banner' => 1,
            'width_banner' => 1600,
            'height_banner' => 400,
            'width_modal' => 400,
            'height_modal' => 400,
            'created_at' => $date
        ]);
    }

    private function deleteAllPhotosInProductPath()
    {
        $path = ConfigBrand::IMAGES_PATH;
        \File::deleteDirectory(storage_path($path), true);
    }

}
