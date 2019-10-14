<?php

use Illuminate\Database\Seeder;

use AVDPainel\Models\Admin\State;

class StateTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        State::create([
            'uf' => 'AC',
            'name' => 'Acre'
        ]);
        State::create([
            'uf' => 'AL',
            'name' => 'Alagoas'
        ]);
        State::create([
            'uf' => 'AM',
            'name' => 'Amazonas'
        ]);
        State::create([
            'uf' => 'AP',
            'name' => 'Amapá'
        ]);
        State::create([
            'uf' => 'BA',
            'name' => 'Bahia'
        ]);
        State::create([
            'uf' => 'CE',
            'name' => 'Ceará'
        ]);
        State::create([
            'uf' => 'DF',
            'name' => 'Distrito Federal'
        ]);
        State::create([
            'uf' => 'ES',
            'name' => 'Espírito Santo'
        ]);
        State::create([
            'uf' => 'GO',
            'name' => 'Goiás'
        ]);
        State::create([
            'uf' => 'MA',
            'name' => 'Maranhão'
        ]);
        State::create([
            'uf' => 'MG',
            'name' => 'Minas Gerais'
        ]);
        State::create([
            'uf' => 'MS',
            'name' => 'Mato Grosso do Sul'
        ]);
        State::create([
            'uf' => 'MT',
            'name' => 'Mato Grosso'
        ]);
        State::create([
            'uf' => 'PA',
            'name' => 'Pará'
        ]);
        State::create([
            'uf' => 'PB',
            'name' => 'Paraíba'
        ]);
        State::create([
            'uf' => 'PE',
            'name' => 'Pernambuco'
        ]);
        State::create([
            'uf' => 'PI',
            'name' => 'Piauí'
        ]);
        State::create([
            'uf' => 'PR',
            'name' => 'Paraná'
        ]);
        State::create([
            'uf' => 'RJ',
            'name' => 'Rio de Janeiro'
        ]);
        State::create([
            'uf' => 'RN',
            'name' => 'Rio Grande do Norte'
        ]);
        State::create([
            'uf' => 'RO',
            'name' => 'Rondônia'
        ]);
        State::create([
            'uf' => 'RR',
            'name' => 'Roraima'
        ]);
        State::create([
            'uf' => 'RS',
            'name' => 'Rio Grande do Sul'
        ]);
        State::create([
            'uf' => 'SC',
            'name' => 'Santa Catarina'
        ]);
        State::create([
            'uf' => 'SE',
            'name' => 'Sergipe'
        ]);
        State::create([
            'uf' => 'SP',
            'name' => 'São Paulo'
        ]);
        State::create([
            'uf' => 'TO',
            'name' => 'Tocantins'
        ]);
    }
}
