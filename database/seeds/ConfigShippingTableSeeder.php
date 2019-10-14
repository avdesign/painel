<?php

use Illuminate\Database\Seeder;

use AVDPainel\Models\Admin\ConfigShipping;

class ConfigShippingTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = date('Y-m-d H:i:s');

        ConfigShipping::create([
            'name' => 'TRANSPORTADORA',
            'description' => 'Você pode indicar uma transportadora de sua preferência (O frete é por conta do cliente)',
            'order' => '01',
            'active' => constLang('active_true'),
            'tax' => 1,
            'tax_unique' => 0,
            'tax_condition' => 0,
            'created_at' => $date
        ]);

        ConfigShipping::create([
            'name' => 'CORREIO (PAC)',
            'description' => 'Frete por conta do cliente (existem algumas restrições de entrega dos meios disponibilizados pelos Correios, como limite de dimensões).',
            'order' => '02',
            'active' => constLang('active_true'),
            'tax' => 1,
            'tax_unique' => 0,
            'tax_condition' => 0,
            'created_at' => $date
        ]);

        ConfigShipping::create([
            'name' => 'CORREIO (SEDEX)',
            'description' => 'Frete por conta do cliente (existem algumas restrições de entrega dos meios disponibilizados pelos Correios, como limite de dimensões).',
            'order' => '03',
            'active' => constLang('active_false'),
            'tax' => 1,
            'tax_unique' => 0,
            'tax_condition' => 0,
            'created_at' => $date
        ]);

        ConfigShipping::create([
            'name' => 'RETIRAR NA LOJA',
            'description' => 'Os produtos deverão ser retirados na própria loja ou em um local combinado.',
            'order' => '04',
            'active' => constLang('active_true'),
            'tax' => 0,
            'tax_unique' => 0,
            'tax_condition' => 0,
            'created_at' => $date
        ]);

        ConfigShipping::create([
            'name' => 'ENTREGAR EM SÃO PAULO (Capital)',
            'description' => 'Não será cobrado valor adicional para entregas na cidade de São Paulo (pedidos acima de R$ 4000,00) .',
            'order' => '05',
            'active' => constLang('active_false'),
            'tax' => 1,
            'tax_unique' => 30,
            'tax_condition' => 1000,
            'created_at' => $date
        ]);

        ConfigShipping::create([
            'name' => 'INDICAR TRANSPORTE',
            'description' => 'Por favor! Digite o nome e o telefone com DDD do contato do transporte, frete por conta do cliente.',
            'order' => '06',
            'active' => constLang('active_false'),
            'tax' => 0,
            'tax_unique' => 0,
            'tax_condition' => 0,
            'created_at' => $date
        ]);
    }
}
