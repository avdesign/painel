<?php

use AVDPainel\Models\Admin\ConfigPercent;

use Illuminate\Database\Seeder;

class ConfigPercentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $date = date('Y-m-d H:i:s');

        ConfigPercent::create([
            'percent' => 5,
            'order' => '01',
            'active' => constLang('active_true'),
            'created_at' => $date,
            'updated_at' => $date
        ]);

        ConfigPercent::create([
            'percent' => 10,
            'order' => '02',
            'active' => constLang('active_true'),
            'created_at' => $date,
            'updated_at' => $date
        ]);

        ConfigPercent::create([
            'percent' => 15,
            'order' => '03',
            'active' => constLang('active_true'),
            'created_at' => $date,
            'updated_at' => $date
        ]);

    }
}
