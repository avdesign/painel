<?php

use Illuminate\Database\Seeder;
use AVDPainel\Models\Admin\Brand;
use AVDPainel\Models\Admin\Product;
use AVDPainel\Models\Admin\Section;
use AVDPainel\Models\Admin\Category;
use AVDPainel\Models\Admin\ImageColor;
use AVDPainel\Models\Admin\GridBrand;
use AVDPainel\Models\Admin\GridSection;
use AVDPainel\Models\Admin\GridCategory;


class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $id_brand          = mt_rand(1, '16789');
        $id_grid_brand     = mt_rand(1, '22346');
        $id_grid_section   = mt_rand(1, '33336');
        $id_grid_category  = mt_rand(1, '76536');

        $id_section    = mt_rand(1, '34680');
        $id_category   = mt_rand(1, '43579');
        $id_product    = mt_rand(1, '2753191');
        $id_color      = mt_rand(1, '16420');

        $date = date('Y-m-d H:i:s');


        //brand 1
        Brand::create([
            'id' => $id_brand,
        	'name' => 'Marca 1',
        	'contact' => 'João Santana',
        	'email' => 'design@anselmovelame.com.br',
            'phone' => '(11) 96938-4849',
        	'address' => 'Rua Orient',
        	'number' => '1',
        	'district' => 'Brás',
        	'city' => 'São Paulo',
        	'state' => 'SP',
        	'zip_code' => '33530-000',
        	'description' => 'Descrição da Marca 1',
        	'slug' => 'marca-1',
        	'tags' => 'marca,1',
        	'visits' => 0,
        	'order' => '01',
        	'active' => constLang('active_true'),
        	'active_logo' => constLang('active_true'),
        	'active_banner' => constLang('active_true'),
            'created_at' => $date
        ]);
        //brand 2
        Brand::create([
            'id' => $id_brand+1,
            'name' => 'Marca 2',
            'contact' => 'João Santana',
            'email' => 'design@anselmovelame.com.br',
            'phone' => '(11) 96938-4849',
            'address' => 'Rua Orient',
            'number' => '1',
            'district' => 'Brás',
            'city' => 'São Paulo',
            'state' => 'SP',
            'zip_code' => '33530-000',
            'description' => 'Descrição da Marca 2',
            'slug' => 'marca-2',
            'tags' => 'marca,2',
            'visits' => 0,
            'order' => '01',
            'active' => constLang('active_true'),
            'active_logo' => constLang('active_true'),
            'active_banner' => constLang('active_true'),
            'created_at' => $date
        ]);

        // grids brand 1 unit
        GridBrand::create([
            'id' => $id_grid_brand,
            'brand_id' => $id_brand,
            'type' => 'unit',
            'name' => 'Unidade',
            'label' => '33,34,35,36,37,38',
            'created_at' => $date
        ]);
        // gris brand 1 kit
        GridBrand::create([
            'id' => $id_grid_brand+1,
            'brand_id' => $id_brand,
            'type' => 'kit',
            'name' => 'Kit',
            'label' => '1/33,2/34,3/35,3/36,2/37,1/38',
            'created_at' => $date
        ]);

        // grids brand 2 unit
        GridBrand::create([
            'id' => $id_grid_brand+2,
            'brand_id' => $id_brand+1,
            'type' => 'unit',
            'name' => 'Unidade',
            'label' => '33,34,35,36,37,38',
            'created_at' => $date
        ]);

        // gris brand 2 kit
        GridBrand::create([
            'id' => $id_grid_brand+3,
            'brand_id' => $id_brand+1,
            'type' => 'kit',
            'name' => 'Kit',
            'label' => '1/33,2/34,3/35,3/36,2/37,1/38',
            'created_at' => $date
        ]);


        // Section 1
        Section::create([
            'id' => $id_section,
            'name' => 'Seção 1',
            'description' => 'Seção 1',
            'slug' => 'secao-1',
            'tags' => 'produto,seção,1',
            'visits' => 0,
            'order' => '01',
            'active' => constLang('active_true'),
            'active_featured' => constLang('active_true'),
            'active_banner' => constLang('active_true'),
            'created_at' => $date
        ]);

        // grids section 1 unit
        GridSection::create([
            'id' => $id_grid_section,
            'section_id' => $id_section,
            'type' => 'unit',
            'name' => 'Unidade',
            'label' => 'P,M,G,GG',
            'created_at' => $date
        ]);
        // gris section 1 kit
        GridSection::create([
            'id' => $id_grid_section+1,
            'section_id' => $id_section,
            'type' => 'kit',
            'name' => 'Kit',
            'label' => '2/P,4/M,2/G,1/GG',
            'created_at' => $date
        ]);

        // Category Section 1
        Category::create([
            'id' => $id_category,
            'section_id' => $id_section,
            'name' => 'Categoria 1',
            'section' => 'Seção 1',
            'description' => 'Seção 1',
            'slug' => 'categoria-1-secao-1',
            'tags' => 'categoria-1,seção 1',
            'visits' => 0,
            'order' => '01',
            'active' => constLang('active_true'),
            'active_featured' => constLang('active_true'),
            'active_banner' => constLang('active_true'),
            'created_at' => $date
        ]);

        // grids category 1 unit
        GridCategory::create([
            'id' => $id_grid_category,
            'category_id' => $id_category,
            'type' => 'unit',
            'name' => 'Unidade',
            'label' => '33-34,35-36,37-38,39-40',
            'created_at' => $date
        ]);
        // gris category 1 kit
        GridCategory::create([
            'id' => $id_grid_category+1,
            'category_id' => $id_category,
            'type' => 'kit',
            'name' => 'Caixa C/12',
            'label' => '1/33-34,4/35-36,5/37-38,2/39-40',
            'created_at' => $date
        ]);

        // gris category 1 kit
        GridCategory::create([
            'id' => $id_grid_category+2,
            'category_id' => $id_category,
            'type' => 'kit',
            'name' => 'Caixa C/6',
            'label' => '1/33-34,2/35-36,2/37-38,1/39-40',
            'created_at' => $date
        ]);


        Product::create([
            'id' => $id_product,
            'brand_id' => $id_brand,
            'section_id' => $id_section,
            'category_id' => $id_category,
            'name' => 'Produto Teste',
            'brand' => 'Marca 1',
            'section' => 'Seção 1',
            'category' => 'Categoria 1',
            'description' => 'Produto 1',
            'slug' => 'produto-teste',
            'unit' => 1,
            'measure' => 'Par',         
            'created_at' => $date
        ]);

        ImageColor::create([
            'id' => $id_color,
            'product_id' => $id_product,
            'color' => 'Branco',
            'code' => '132442',
            'image' => 'image.jpg',
            'slug' => 'produto-1-cor-1-132442',
            'order' => '01',
            'active' => 1,
            'created_at' => $date
        ]);


        DB::table('products')->delete();

    }
}
