<?php

use Illuminate\Database\Seeder;
use AVDPainel\Models\Admin\ConfigColorPosition;

use Illuminate\Support\Facades\Storage;


class ConfigColorPositionTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->deleteAllPhotosInProductPath();

        ConfigColorPosition::create([
            'type' => 'C',
            'path' => 'images/products/100x100/',
            'width' => '100',
            'height' => '100',
            'default' => 'T'
        ]);

        ConfigColorPosition::create([
            'type' => 'C',
            'path' => 'images/products/370x370/',
            'width' => '370',
            'height' => '370',
            'default' => 'N'

        ]);

        ConfigColorPosition::create([
            'type' => 'C',
            'path' => 'images/products/800x800/',
            'width' => '800',
            'height' => '800',
            'default' => 'G'

        ]);

        ConfigColorPosition::create([
            'type' => 'C',
            'path' => 'images/products/1000x1000/',
            'width' => '1000',
            'height' => '1000',
            'default' => 'Z'
        ]);

        ConfigColorPosition::create([
            'type' => 'P',
            'path' => 'images/products/100x100/',
            'width' => '100',
            'height' => '100',
            'default' => 'T'
        ]);

        ConfigColorPosition::create([
            'type' => 'P',
            'path' => 'images/products/370x370/',
            'width' => '370',
            'height' => '370',
            'default' => 'N'

        ]);

        ConfigColorPosition::create([
            'type' => 'P',
            'path' => 'images/products/800x800/',
            'width' => '800',
            'height' => '800',
            'default' => 'G'

        ]);

        ConfigColorPosition::create([
            'type' => 'P',
            'path' => 'images/products/1000x1000/',
            'width' => '1000',
            'height' => '1000',
            'default' => 'Z'
        ]);
    }


    private function deleteAllPhotosInProductPath()
    {
        $path = ConfigColorPosition::IMAGES_PATH;
        \File::deleteDirectory(storage_path($path), true);
    }

}
