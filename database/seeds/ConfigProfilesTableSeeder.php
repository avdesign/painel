<?php


use AVDPainel\Models\Admin\ConfigProfile;
use Illuminate\Database\Seeder;

class ConfigProfilesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $date = date('Y-m-d H:i:s');

        ConfigProfile::create([
        	'name' => 'Master',
        	'label' => 'Super Admin.',
            'created_at' => $date
        ]);

        ConfigProfile::create([
        	'name' => 'Administrador',
        	'label' => 'Acesso a todos os modulos do sistema.',
            'created_at' => $date
        ]);

        ConfigProfile::create([
        	'name' => 'Vendedor',
            'label' => 'Acesso somente aos modulos vinculados ao seu perfil.',
            'created_at' => $date
        ]);

        ConfigProfile::create([
            'name' => 'Editor',
            'label' => 'Acesso somente aos modulos vinculados ao seu perfil.',
            'created_at' => $date
        ]);

    }
}
