<?php

namespace AVDPainel\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class ConfigSite extends Model
{
    protected $table = 'config_site';

    protected $fillable = [
        'header',
        'menu',
        'breadcrumbs',
        'countdown',
        'social_share',
        'page_home',
        'page_products',
        'page_categories',
        'page_sections',
        'page_brands',
        'list',
        'limit_products',
        'detail_products',
        'tabs_products',
        'long_description',
        'comments_products',
        'tags_products',
        'related_products',
        'sidebar_products',
        'image_colors',
        'image_positions',
        'change_images',
        'order_products',
        'order'
    ];

}
