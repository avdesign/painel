<?php

use Illuminate\Database\Seeder;
use AVDPainel\Models\Admin\ConfigProfileClient;


class ConfigProfileClientTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = date('Y-m-d H:i:s');

        ConfigProfileClient::create([
            'default' => 1,
            'order' => '01',
            'name' => 'Atacado',
            'percent_cash' => 0,
            'percent_card' => 0,
            'sum' => '-',
            'active' => constLang('active_true'),
            'created_at' => $date,
            'updated_at' => $date
        ]);

        ConfigProfileClient::create([
            'default' => 0,
            'order' => '02',
            'name' => 'Varejo',
            'percent_cash' => 20,
            'percent_card' => 25,
            'sum' => '+',
            'active' => constLang('active_true'),
            'created_at' => $date,
            'updated_at' => $date
        ]);


    }
}
