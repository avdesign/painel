<?php

use Illuminate\Database\Seeder;
use AVDPainel\Models\Admin\ConfigSite;

class ConfigSiteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = date('Y-m-d H:i:s');

        ConfigSite::create([
            'header' => 1,
            'menu' => 1,
            'breadcrumbs' => 1,
            'countdown' => 1,
            'social_share' => 1,
            'page_home' => 1,
            'page_products' => 1,
            'page_categories' => 1,
            'page_sections' => 1,
            'page_brands' => 1,
            'limit_products' => 1,
            'list' => 1,
            'detail_products' => 1,
            'tabs_products' => 1,
            'long_description' => 1,
            'comments_products' => 1,
            'tags_products' => 1,
            'related_products' => 1,
            'sidebar_products' => 1,
            'image_colors' => 1,
            'image_positions' => 1,
            'change_images' => 1,
            'order_products' => 'random',
            'order' => 'cart',
            'created_at' => $date
        ]);


    }
}
