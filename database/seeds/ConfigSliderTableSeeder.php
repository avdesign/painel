<?php

use Illuminate\Database\Seeder;
use AVDPainel\Models\Admin\ConfigSlider;


class ConfigSliderTableSeeder extends Seeder
{
    /**
     * Configuração do slider da home
     *
     * @return void
     */
    public function run()
    {
        $date = date('Y-m-d H:i:s');
        $this->deleteAllPhotosInProductPath();


        ConfigSlider::create([
            'type' => 'banner',
            'active' => constLang('active_true'),
            'delay' => 3000,
            'path' => 'images/slider/',
            'width' => '1260',
            'height' => '1200',
            'width_thumb' => '100',
            'height_thumb' => '95',
            'width_modal' => '800',
            'height_modal' => '800',
            'created_at' => $date
        ]);
    }

    private function deleteAllPhotosInProductPath()
    {
        $path = ConfigSlider::IMAGES_PATH;
        \File::deleteDirectory(storage_path($path), true);
    }
}
