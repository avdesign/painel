<?php

use Illuminate\Database\Seeder;
use AVDPainel\Models\Admin\ConfigSection;

class ConfigSectionTableSeeder extends Seeder
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


        ConfigSection::create([
            'grids' => 1,
            'description' => 1,
            'img_default' => 'D',
            'path' => 'images/sections/',
            'img_featured' => 1,
            'width_featured' => 220,
            'height_featured' => 300,
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
        $path = ConfigSection::IMAGES_PATH;
        \File::deleteDirectory(storage_path($path), true);
    }

}
