<?php

use Illuminate\Database\Seeder;
use AVDPainel\Models\Admin\ConfigProduct;

class ConfigProductTableSeeder extends Seeder
{
    /**
     * Config Product.
     *
     * @return void
     */
    public function run()
    {
        $date = date('Y-m-d H:i:s');
        ConfigProduct::create([
            'price_default' => 'Atacado',
            'config_prices' => 1,
            'view_prices' => 1,
            'price_profile' => 1,
	        'cost' => 1,
	        'stock' => 1,
	        'freight' => 1,
	        'kit' => 1,
	        'qty_min_kit' => 2,
	        'qty_max_kit' => 20,
	        'qty_min_unit' => 10,
	        'qty_max_unit' => 100,
	        'colors' => 1,
	       	'group_colors' => 1,
	        'positions' => 1,
	        'code' => 1,
	        'grids' => 1,
            'reviews' => 0,
            'quickview' => 1,
            'wishlist' => 1,
            'compare' => 1,
            'countdown' => 1,
	        'video' => 1,
	        'mini_colors' => 'hexa',
            'created_at' => $date
        ]);
    }
}
