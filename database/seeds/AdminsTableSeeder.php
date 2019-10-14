<?php

use Illuminate\Database\Seeder;
use AVDPainel\Models\Admin\Admin;
use AVDPainel\Models\Admin\ConfigSystem;
use AVDPainel\Models\Admin\AdminAccess;

class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $id   = mt_rand(1, '123456789');
        $date = date('Y-m-d H:i:s');
        $this->deleteAllPhotosInProductPath();


        Admin::create([
            'id' => $id,
        	'name' => 'Anselmo',
        	'login' => 'Anselmo',
            'profile' => 'Master',
            'phone' => '(11) 96938-4849',
            'email' => 'suporte.avdesign@gmail.com',
            'active' => constLang('active_true'),
            'commission' => constLang('yes'),
            'percent' => 1,
        	'password' => 'avdesign',
            'created_at' => $date
        ]);

        ConfigSystem::create([
            'admin_id' => $id,
            'table_color' => 'anthracite-gradient',
            'table_color_sel' => 'anthracite-gradient',
            'table_limit' => 50,
            'table_open_details' => 'td.details-control',
            'created_at' => $date
        ]);

        AdminAccess::create([
            'admin_id' => $id,
            'last_ip' => '',
            'last_url' => 'config/system',
            'last_logout' => '',
            'qty_visits' => 0
        ]);

    }

    /**
     * Accesses.user/files txt
     */
    private function deleteAllPhotosInProductPath()
    {
        $path = AdminAccess::FILES_PATH;
        \File::deleteDirectory(storage_path($path), true);
    }

}
