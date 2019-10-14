<?php

use AVDPainel\Models\Admin\ConfigColorGroup;


use Illuminate\Database\Seeder;


class ConfigColorGroupTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     *
     * @return void
     */
    public function run()
    {
        ConfigColorGroup::create([ 
                "code" => "#000000",
                "name" => "Preto",
                "order" => '01',
                "active" => constLang('active_true')
            ]);
        ConfigColorGroup::create([ 
                "code" => "#a9a9a9",
                "name" => "Cinza",
                "order" => '02',
                "active" => constLang('active_true')
            ]);
        ConfigColorGroup::create([ 
                "code" => "#d3d3d3",
                "name" => "Prata",
                "order" => '03',
                "active" => constLang('active_true')
            ]);
        ConfigColorGroup::create([ 
                "code" => "#ffffff",
                "name" => "Branco",
                "order" => '03',
                "active" => constLang('active_true')
            ]);
        ConfigColorGroup::create([ 
                "code" => "#0000cd",
                "name" => "Azul Escuro",
                "order" => "04",
                "active" => constLang('active_true')
            ]);
        ConfigColorGroup::create([ 
                "code" => "#6495ed",
                "name" => "Azul Medio",
                "order" => "05",
                "active" => constLang('active_true')
            ]);
        ConfigColorGroup::create([ 
                "code" => "#20b2aa",
                "name" => "Azul Turquesa",
                "order" => "06",
                "active" => constLang('active_true')
            ]);
        ConfigColorGroup::create([ 
                "code" => "#afeeee",
                "name" => "Azul Claro",
                "order" => "07",
                "active" => constLang('active_true')
            ]);
        ConfigColorGroup::create([ 
                "code" => "#006400",
                "name" => "Verde Escuro",
                "order" => "08",
                "active" => constLang('active_true')
            ]);
        ConfigColorGroup::create([ 
                "code" => "#32cd32",
                "name" => "Verde Medio",
                "order" => "09",
                "active" => constLang('active_true')
            ]);
        ConfigColorGroup::create([ 
                "code" => "#90ee90",
                "name" => "Verde Claro",
                "order" => 10,
                "active" => constLang('active_true')
            ]);
        ConfigColorGroup::create([ 
                "code" => "#ff0000",
                "name" => "Vermelho",
                "order" => 11,
                "active" => constLang('active_true')
            ]);
        ConfigColorGroup::create([ 
                "code" => "#ff8c00",
                "name" => "Laranja",
                "order" => 12,
                "active" => constLang('active_true')
            ]);
        ConfigColorGroup::create([ 
                "code" => "#ffff00",
                "name" => "Amarelo",
                "order" => 13,
                "active" => constLang('active_true')
            ]);
        ConfigColorGroup::create([ 
                "code" => "#c71585",
                "name" => "Violeta",
                "order" => 14,
                "active" => constLang('active_true')
            ]);
        ConfigColorGroup::create([ 
                "code" => "#db7093",
                "name" => "Rosa",
                "order" => 15,
                "active" => constLang('active_true')
            ]);
        ConfigColorGroup::create([ 
                "code" => "#ff69b4",
                "name" => "Pink",
                "order" => 16,
                "active" => constLang('active_true')
            ]);
        ConfigColorGroup::create([ 
                "code" => "#800080",
                "name" => "Lilás ",
                "order" => 17,
                "active" => constLang('active_true')
            ]);
        ConfigColorGroup::create([ 
                "code" => "#9932cc",
                "name" => "Lilás Light",
                "order" => 18,
                "active" => constLang('active_true')
            ]);
        ConfigColorGroup::create([ 
                "code" => "#4b0082",
                "name" => "Indigo",
                "order" => 19,
                "active" => constLang('active_true')
            ]);
        ConfigColorGroup::create([ 
                "code" => "#ffc0cb",
                "name" => "Rose",
                "order" => 20,
                "active" => constLang('active_true')
            ]);
        ConfigColorGroup::create([ 
                "code" => "#ee82ee",
                "name" => "Orquídea",
                "order" => 21,
                "active" => constLang('active_true')
            ]);
        ConfigColorGroup::create([ 
                "code" => "#ff00ff",
                "name" => "Magenta",
                "order" => 22,
                "active" => constLang('active_true')
            ]);
        ConfigColorGroup::create([ 
                "code" => "#800000",
                "name" => "Marom",
                "order" => 23,
                "active" => constLang('active_true')
            ]);
        ConfigColorGroup::create([ 
                "code" => "#cd5c5c",
                "name" => "Coral",
                "order" => 24,
                "active" => constLang('active_true')
            ]);
        ConfigColorGroup::create([ 
                "code" => "#cd853f",
                "name" => "Chocolate",
                "order" => 25,
                "active" => constLang('active_true')
            ]);
        ConfigColorGroup::create([ 
                "code" => "#daa520",
                "name" => "Peru",
                "order" => 26,
                "active" => constLang('active_true')
            ]);
        ConfigColorGroup::create([ 
                "code" => "#d2691e",
                "name" => "Chocolate",
                "order" => 27,
                "active" => constLang('active_true')
            ]);
        ConfigColorGroup::create([ 
                "code" => "#ffe4b5",
                "name" => "Navajo",
                "order" => 28,
                "active" => constLang('active_true')
            ]);
        ConfigColorGroup::create([ 
                "code" => "#e9967a",
                "name" => "Sienna",
                "order" => 29,
                "active" => constLang('active_true')
            ]);
        ConfigColorGroup::create([ 
                "code" => "#d2b48c",
                "name" => "Bronze",
                "order" => 30,
                "active" => constLang('active_true')
            ]);
        ConfigColorGroup::create([ 
                "code" => "#dc143c",
                "name" => "Bordo",
                "order" => 31,
                "active" => constLang('active_true')
            ]);
        ConfigColorGroup::create([ 
                "code" => "#a9a741",
                "name" => "Oliva",
                "order" => 32,
                "active" => constLang('active_true')
            ]);
        ConfigColorGroup::create([ 
                "code" => "#eee8aa",
                "name" => "Nude",
                "order" => 33,
                "active" => constLang('active_true')
            ]);
    }
}
