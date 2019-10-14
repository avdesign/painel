<?php

use Illuminate\Database\Seeder;
use AVDPainel\Models\Admin\ConfigAdmin;


class ConfigAdminTableSeeder extends Seeder
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


        ConfigAdmin::create([
            'path' => 'images/admins/',
            'width_photo' => 300,
            'height_photo' => 300,
            'created_at' => $date
        ]);
    }


    private function deleteAllPhotosInProductPath()
    {
        $path = ConfigAdmin::IMAGES_PATH;
        \File::deleteDirectory(storage_path($path), true);
    }

}
