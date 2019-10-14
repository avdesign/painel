<?php

use Illuminate\Database\Seeder;
use AVDPainel\Models\Admin\ConfigBanner;

class ConfigBannerTableSeeder extends Seeder
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

        ConfigBanner::create([
            'type' => 'four',
            'active' => constLang('active_true'),
            'path' => 'images/banners/',
            'width' => '262',
            'height' => '256',
            'created_at' => $date
        ]);
    }

    private function deleteAllPhotosInProductPath()
    {
        $path = ConfigBanner::IMAGES_PATH;
        \File::deleteDirectory(storage_path($path), true);
    }

}
