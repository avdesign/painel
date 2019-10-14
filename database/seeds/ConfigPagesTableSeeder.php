<?php

use Illuminate\Database\Seeder;
use AVDPainel\Models\Admin\ConfigPage;
use AVDPainel\Models\Admin\ConfigTemplate;

class ConfigPagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = date('Y-m-d H:i:s');
        //Page Home
        ConfigPage::create([
            'id' => 1,
            'name' => 'Home',
            'module' => 'home',
            'active' => constLang('active_true'),
            'created_at' => $date
        ]);
        //Modules Home
        ConfigTemplate::create([
            'config_page_id' => 1,
            'tmp' => 1,
            'name' => 'Slider',
            'module' => 'slider',
            'active' => constLang('active_true'),
            'created_at' => $date
        ]);
        ConfigTemplate::create([
            'config_page_id' => 1,
            'tmp' => 1,
            'name' => 'Banner',
            'module' => 'banner',
            'active' => constLang('active_true'),
            'created_at' => $date
        ]);
        ConfigTemplate::create([
            'config_page_id' => 1,
            'tmp' => 1,
            'name' => 'Ofertas',
            'module' => 'offer',
            'active' => constLang('active_true'),
            'created_at' => $date
        ]);
        ConfigTemplate::create([
            'config_page_id' => 1,
            'tmp' => 1,
            'name' => 'Novos',
            'module' => 'new',
            'active' => constLang('active_true'),
            'created_at' => $date
        ]);
        ConfigTemplate::create([
            'config_page_id' => 1,
            'tmp' => 1,
            'name' => 'Destaques',
            'module' => 'featured',
            'active' => constLang('active_true'),
            'created_at' => $date
        ]);
        ConfigTemplate::create([
            'config_page_id' => 1,
            'tmp' => 1,
            'name' => 'Seções',
            'module' => 'section',
            'active' => constLang('active_true'),
            'created_at' => $date
        ]);
        ConfigTemplate::create([
            'config_page_id' => 1,
            'tmp' => 1,
            'name' => 'Categorias',
            'module' => 'category',
            'active' => constLang('active_true'),
            'created_at' => $date
        ]);
        ConfigTemplate::create([
            'config_page_id' => 1,
            'tmp' => 1,
            'name' => 'Marcas',
            'module' => 'brand',
            'active' => constLang('active_true'),
            'created_at' => $date
        ]);
        // Page Sections
        ConfigPage::create([
            'id' => 2,
            'name' => 'Seções',
            'module' => 'sections',
            'active' => constLang('active_true'),
            'created_at' => $date
        ]);
        //Modules Sections
        ConfigTemplate::create([
            'config_page_id' => 2,
            'tmp' => 1,
            'name' => 'Seção',
            'module' => 'section',
            'active' => constLang('active_true'),
            'created_at' => $date
        ]);
        //Page Categories
        ConfigPage::create([
            'id' => 3,
            'name' => 'Categorias',
            'module' => 'categories',
            'active' => constLang('active_true'),
            'created_at' => $date
        ]);
        //Modules Categories
        ConfigTemplate::create([
            'config_page_id' => 3,
            'tmp' => 1,
            'name' => 'Categoria',
            'module' => 'category',
            'active' => constLang('active_true'),
            'created_at' => $date
        ]);
        //Page Products
        ConfigPage::create([
            'id' => 4,
            'name' => 'Produtos',
            'module' => 'products',
            'active' => constLang('active_true'),
            'created_at' => $date
        ]);
        //Modules Products
        ConfigTemplate::create([
            'config_page_id' => 4,
            'tmp' => 1,
            'name' => 'Produto',
            'module' => 'product',
            'active' => constLang('active_true'),
            'created_at' => $date
        ]);
        ConfigTemplate::create([
            'config_page_id' => 4,
            'tmp' => 1,
            'name' => 'Banner',
            'module' => 'banner',
            'active' => constLang('active_true'),
            'created_at' => $date
        ]);
        ConfigTemplate::create([
            'config_page_id' => 4,
            'tmp' => 1,
            'name' => 'Ofertas',
            'module' => 'offer',
            'active' => constLang('active_true'),
            'created_at' => $date
        ]);
        ConfigTemplate::create([
            'config_page_id' => 4,
            'tmp' => 1,
            'name' => 'Destaques',
            'module' => 'featured',
            'active' => constLang('active_true'),
            'created_at' => $date
        ]);
        ConfigTemplate::create([
            'config_page_id' => 4,
            'tmp' => 1,
            'name' => 'Tabs',
            'module' => 'tab',
            'active' => constLang('active_true'),
            'created_at' => $date
        ]);
        ConfigTemplate::create([
            'config_page_id' => 4,
            'tmp' => 1,
            'name' => 'Descrição',
            'module' => 'description',
            'active' => constLang('active_true'),
            'created_at' => $date
        ]);
        ConfigTemplate::create([
            'config_page_id' => 4,
            'tmp' => 1,
            'name' => 'Comentários',
            'module' => 'review',
            'active' => constLang('active_true'),
            'created_at' => $date
        ]);
        ConfigTemplate::create([
            'config_page_id' => 4,
            'tmp' => 1,
            'name' => 'Relacionados',
            'module' => 'related',
            'active' => constLang('active_true'),
            'created_at' => $date
        ]);

        // Congig List Products
        ConfigPage::create([
            'id' => 5,
            'name' => 'Ordenar Produtos',
            'module' => 'order',
            'active' => constLang('active_true'),
            'created_at' => $date
        ]);
        ConfigTemplate::create([
            'config_page_id' => 5,
            'tmp' => 1,
            'name' => 'Aleatório',
            'module' => 'random',
            'active' => constLang('active_true'),
            'created_at' => $date
        ]);
        ConfigTemplate::create([
            'config_page_id' => 5,
            'tmp' => 2,
            'name' => 'Crescente',
            'module' => 'asc',
            'active' => constLang('active_false'),
            'created_at' => $date
        ]);
        ConfigTemplate::create([
            'config_page_id' => 5,
            'tmp' => 3,
            'name' => 'Decrescente',
            'module' => 'desc',
            'active' => constLang('active_false'),
            'created_at' => $date
        ]);
    }
}
