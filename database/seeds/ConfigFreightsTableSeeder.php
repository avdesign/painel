
<?php

use Illuminate\Database\Seeder;
use AVDPainel\Models\Admin\ConfigFreight;

class ConfigFreightsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = date('Y-m-d H:i:s');
        ConfigFreight::create([
            'default' => 1,
            'distribute_box' => 1,
            'weight' => 1,
            'width' => 1,
            'height' => 1,
            'length' => 1,
            'declare' => 1,
            'created_at' => $date
        ]);
    }
}