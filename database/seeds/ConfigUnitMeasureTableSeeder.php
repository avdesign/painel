<?php

use AVDPainel\Models\Admin\ConfigUnitMeasure;

use Illuminate\Database\Seeder;

class ConfigUnitMeasureTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ConfigUnitMeasure::create([
        	'unit' => 1,
        	'name' => 'Par',
        	'order' => '01',
            'active' => constLang('active_true')
        ]);

        ConfigUnitMeasure::create([
        	'unit' => 6,
        	'name' => 'Pares',
        	'order' => '02',
            'active' => constLang('active_true')
        ]);

        ConfigUnitMeasure::create([
        	'unit' => 12,
        	'name' => 'Pares',
        	'order' => '03',
            'active' => constLang('active_true')
        ]);


    }
}
