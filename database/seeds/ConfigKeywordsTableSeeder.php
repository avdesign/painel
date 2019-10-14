<?php

use Illuminate\Database\Seeder;

use AVDPainel\Models\Admin\ConfigKeyword;

class ConfigKeywordsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = date('Y-m-d H:i:s');
        
        ConfigKeyword::create([
            'title' => 'Atacado',
            'description' => 'Atacado de Calçados',
            'keywords' => 'atacado,calçados',
            'genders' => 'feminino,masculino,juvenil,infantil,bebe',
            'categories' => 'botas,mocassim,sapatilhas,oxford,alpargatas,peep toe,ankle boot, espadrille,sandálias,tamancos,ana bela,gladiadoras,chinelos,scarpim,rasteiras,slippers,casual,havaianas,tênis,',
            'active' => constLang('active_true'),
            'created_at' => $date
        ]);

        ConfigKeyword::create([
            'title' => 'Distribuidor',
            'description' => 'Distribuidor de Calçados',
            'keywords' => 'distribuidor,calçados,atacado',
            'genders' => 'feminino,masculino,juvenil,infantil,bebe',
            'categories' => 'botas,mocassim,sapatilhas,oxford,alpargatas,peep toe,ankle boot, espadrille,sandálias,tamancos,ana bela,gladiadoras,chinelos,scarpim,rasteiras,slippers,casual,havaianas,tênis,',
            'active' => constLang('active_true'),
            'created_at' => $date
        ]);

        ConfigKeyword::create([
            'title' => 'Distribuidora',
            'description' => 'Distribuidora de Calçados',
            'keywords' => 'distribuidora,calçados,atacado',
            'genders' => 'feminino,masculino,juvenil,infantil,bebe',
            'categories' => 'botas,mocassim,sapatilhas,oxford,alpargatas,peep toe,ankle boot, espadrille,sandálias,tamancos,ana bela,gladiadoras,chinelos,scarpim,rasteiras,slippers,casual,havaianas,tênis,',
            'active' => constLang('active_true'),
            'created_at' => $date
        ]);

        ConfigKeyword::create([
            'title' => 'Atacadista',
            'description' => 'Atacadista de Calçados',
            'keywords' => 'atacadista,distribuidora,calçados,revenda,atacado',
            'genders' => 'feminino,masculino,juvenil,infantil,bebe',
            'categories' => 'botas,mocassim,sapatilhas,oxford,alpargatas,peep toe,ankle boot, espadrille,sandálias,tamancos,ana bela,gladiadoras,chinelos,scarpim,rasteiras,slippers,casual,havaianas,tênis,',
            'active' => constLang('active_true'),
            'created_at' => $date
        ]);

        ConfigKeyword::create([
            'title' => 'Fabrica',
            'description' => 'Fabrica de Calçados',
            'keywords' => 'fabrica,atacadista,calçados,atacado',
            'genders' => 'feminino,masculino,juvenil,infantil,bebe',
            'categories' => 'botas,mocassim,sapatilhas,oxford,alpargatas,peep toe,ankle boot, espadrille,sandálias,tamancos,ana bela,gladiadoras,chinelos,scarpim,rasteiras,slippers,casual,havaianas,tênis,',
            'active' => constLang('active_true'),
            'created_at' => $date
        ]);

        ConfigKeyword::create([
            'title' => 'Fabricante',
            'description' => 'Fabricante de calçados preço de atacado',
            'keywords' => 'fabricante,distribuidor,calçados,revenda,atacado',
            'genders' => 'feminino,masculino,juvenil,infantil,bebe',
            'categories' => 'botas,mocassim,sapatilhas,oxford,alpargatas,peep toe,ankle boot, espadrille,sandálias,tamancos,ana bela,gladiadoras,chinelos,scarpim,rasteiras,slippers,casual,havaianas,tênis,',
            'active' => constLang('active_true'),
            'created_at' => $date
        ]);

        ConfigKeyword::create([
            'title' => 'Revendedor',
            'description' => 'Revendedor de Calçados',
            'keywords' => 'revendedor,distribuidor,calçados,atacado',
            'genders' => 'feminino,masculino,juvenil,infantil,bebe',
            'categories' => 'botas,mocassim,sapatilhas,oxford,alpargatas,peep toe,ankle boot, espadrille,sandálias,tamancos,ana bela,gladiadoras,chinelos,scarpim,rasteiras,slippers,casual,havaianas,tênis,',
            'active' => constLang('active_true'),
            'created_at' => $date
        ]);

    }
}
