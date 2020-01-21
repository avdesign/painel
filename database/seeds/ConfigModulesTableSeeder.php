<?php

use AVDPainel\Models\Admin\ConfigModule;
use Illuminate\Database\Seeder;

class ConfigModulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = date('Y-m-d H:i:s');

        ConfigModule::create([
            'type'   => 'C',
        	'name'   => 'Configurações',
        	'label'  => 'Configurações padrões do sistema.',
            'order'  => '01',
            'created_at' => $date
        ]);

        ConfigModule::create([
            'type'   => 'C',
            'name'   => 'Modulos',
            'label'  => 'Modulos do sistema.',
            'order'  => '02',
            'created_at' => $date
        ]);

        ConfigModule::create([
            'type'   => 'C',
            'name'   => 'Perfis',
            'label'  => 'Perfil dos usuários.',
            'order'  => '03',
            'created_at' => $date
        ]);

        ConfigModule::create([
            'type'   => 'C',
            'name'   => 'Permissões',
            'label'  => 'Permissões de acessos dos usuários.',
            'order'  => '04',
            'created_at' => $date
        ]);

        ConfigModule::create([
            'type'  => 'C',
            'name'   => 'Configuração dos Produtos',
            'label'  => 'Habilita os modulos vinculados ao produto.',
            'order'  => '05',
            'created_at' => $date
        ]);

        ConfigModule::create([
            'type'   => 'C',
            'name'   => 'Frete (coreio)',
            'label'  => 'Editar o frete do correio.',
            'order'  => '06',
            'created_at' => $date
        ]);

        ConfigModule::create([
            'type'   => 'C',
            'name'   => 'Palavras Chaves (SEO)',
            'label'  => 'Editar as palavras chaves para os mecanismos de busca.',
            'order'  => '07',
            'created_at' => $date
        ]);

        ConfigModule::create([
            'type'   => 'C',
            'name'   => 'Porcentagens',
            'label'  => 'Editar porcentagens dos preços.',
            'order'  => '08',
            'created_at' => $date
        ]);

        ConfigModule::create([
            'type'   => 'C',
            'name'   => 'Métodos de Envio',
            'label'  => 'Específica os métodos de envio.',
            'order'  => '09',
            'created_at' => $date
        ]);


        ConfigModule::create([
            'type'   => 'C',
            'name'   => 'Unidades de Medidas',
            'label'  => 'Específica a unidade de medida do produto.',
            'order'  => '10',
            'created_at' => $date
        ]);

        ConfigModule::create([
            'type'  => 'C',
            'name'   => 'Imagens e formulário dos fabricantes',
            'label'  => 'Padrão das imagens, grades e informações sobre os fabricantes',
            'order'  => '11',
            'created_at' => $date
        ]);

        ConfigModule::create([
            'type'  => 'C',
            'name'   => 'Imagens e formulário das seções',
            'label'  => 'Padrão das imagens, grades e descrição das seções',
            'order'  => '12',
            'created_at' => $date
        ]);

        ConfigModule::create([
            'type'  => 'C',
            'name'   => 'Imagens e formulário das categorias',
            'label'  => 'Padrão das imagens, grades e descrição das categorias',
            'order'  => '13',
            'created_at' => $date
        ]);

        ConfigModule::create([
            'type'  => 'C',
            'name'   => 'Imagens dos produtos',
            'label'  => 'Padrão das imagens dos produtos',
            'order'  => '14',
            'created_at' => $date
        ]);

        ConfigModule::create([
            'type'  => 'C',
            'name'   => 'Grupo de Cores',
            'label'  => 'Definir as cores basicas para uma pesquisa.',
            'order'  => '15',
            'created_at' => $date
        ]);

        ConfigModule::create([
            'type'  => 'C',
            'name'   => 'Vendas por kits',
            'label'  => 'Vendas por caixa, kits, embalagem etc.',
            'order'  => '16',
            'created_at' => $date
        ]);

        ConfigModule::create([
            'type'  => 'C',
            'name'   => 'Editar porcentagem por perfil',
            'label'  => 'Porcentagem dos preços por perfil do cliente.',
            'order'  => '17',
            'created_at' => $date
        ]);

        ConfigModule::create([
            'type'  => 'A',
            'name'   => 'Usuários do Sistema',
            'label'  => 'Permissões dos Usuarios',
            'order'  => '01',
            'created_at' => $date
        ]);

        ConfigModule::create([
            'type'  => 'A',
            'name'   => 'Fabricantes',
            'label'  => 'Marcas do produtos',
            'order'  => '02',
            'created_at' => $date
        ]);

        ConfigModule::create([
            'type'  => 'A',
            'name'   => 'Seções',
            'label'  => 'Seções dos produtos',
            'order'  => '03',
            'created_at' => $date
        ]);

        ConfigModule::create([
            'type'  => 'A',
            'name'   => 'Categorias',
            'label'  => 'Categorias dos produtos',
            'order'  => '04',
            'created_at' => $date
        ]);

        ConfigModule::create([
            'type'  => 'A',
            'name'   => 'Catalogo',
            'label'  => 'Catalogo dos produtos',
            'order'  => '05',
            'created_at' => $date
        ]);

        ConfigModule::create([
            'type'  => 'A',
            'name'   => 'Lista de Desejos',
            'label'  => 'Lista dos produtos desejados pelos clientes.',
            'order'  => '06',
            'created_at' => $date
        ]);

        ConfigModule::create([
            'type'  => 'C',
            'name'   => 'Assuntos dos Contato',
            'label'  => 'Editar assuntos do formulário de contato',
            'order'  => '18',
            'created_at' => $date
        ]);

        ConfigModule::create([
            'type'  => 'A',
            'name'   => 'Contatos',
            'label'  => 'Mensagens dos contatos',
            'order'  => '07',
            'created_at' => $date
        ]);

        ConfigModule::create([
            'type' => 'C',
            'name' => 'Status dos Pedidos',
            'label' => 'Configuração dos status dos pedidos',
            'order' => '19',
            'created_at' => $date
        ]);

        ConfigModule::create([
            'type' => 'C',
            'name' => 'Formas de Pagamentos',
            'label' => 'Configuração das formas de pagamentos',
            'order' => '20',
            'created_at' => $date
        ]);

        ConfigModule::create([
            'type' => 'A',
            'name' => 'Pedidos',
            'label' => 'Pedidos dos Clientes',
            'order' => '08',
            'created_at' => $date
        ]);

        ConfigModule::create([
            'type' => 'A',
            'name' => 'Cadastro de Clientes',
            'label' => 'Modulo do cadastro dos clientes',
            'order' => '09',
            'created_at' => $date
        ]);

        ConfigModule::create([
            'type' => 'C',
            'name' => 'Configuração do Slider',
            'label' => 'Padrão das imagens do slider da home',
            'order' => '21',
            'created_at' => $date
        ]);

        ConfigModule::create([
            'type' => 'A',
            'name' => 'Manipulação das Imagens',
            'label' => 'Manipulação das imagens do site',
            'order' => '10',
            'created_at' => $date
        ]);

        ConfigModule::create([
            'type' => 'A',
            'name' => 'Conteúdos do site',
            'label' => 'Conteúdos de informações sobre o site ',
            'order' => '11',
            'created_at' => $date
        ]);

        ConfigModule::create([
            'type' => 'A',
            'name' => 'Inventário',
            'label' => 'Inventaŕio de todas as entradas e saidas do estoque',
            'order' => '12',
            'created_at' => $date
        ]);

        ConfigModule::create([
            'type' => 'A',
            'name' => 'Controle de Estoque',
            'label' => 'Controle da entrada e saida do estoque',
            'order' => '13',
            'created_at' => $date
        ]);

    }




    /*
    |--------------------------------------------------------------------------
    | Modules
    |--------------------------------------------------------------------------
    | 1 - Configuração do sistema.
    | 2 - Modulos do sistema.
    | 3 - Perfis dos usuários.
    | 4 - Prmissões para os perfis.
    | 5 - Configurações dos Produtos.
    | 6 - Frete (cooreio).
    | 7 - Palavras Chaves (SEO).
    | 8 - Porcentagens.
    | 9 - Métodos de envio.
    | 10- Unidades de Medidas
    | 11- Imagens formulário das marcas.
    | 12- Imagens formulário das seções
    | 13- Imagens formulário das categorias
    | 14- Imagens dos produtos
    | 15- Grupo de Cores
    | 16- Vendas por Kits
    | 17- Perfil do Cliente
    | 18- Usuários do Sistema
    | 19- Fabricantes
    | 20- Seções
    | 21- Categorias
    | 22- Catalogo
    | 23- Lista de Desejos
    | 24- Assuntos dos Contato
    | 25- Contatos
    | 26- Status dos Pedidos
    | 27- Formas de Pagamentos
    | 28- Pedidos
    | 29- Cadastro de Clientes
    | 30- Configuração do slide da home
    | 31- Manipulação das imagens do site
    | 32- Conteúdos do site
    | 33- Inventário do Estoque
    | 34- Controle de Estoque

    */    
}

