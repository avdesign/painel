<?php

use Illuminate\Database\Seeder;
use AVDPainel\Models\Admin\ConfigFormPayment;

class ConfigFormPaymentTableSeeder extends Seeder
{
    /**
     * Table Form Pagament.
     *
     * @return void
     */
    public function run()
    {
        $date = date('Y-m-d H:i:s');

        ConfigFormPayment::create([
            'method' => 'cash',
            'order' => '01',
            'label' => 'Depósito em Conta',
            'description' => '
                -Banco: '.env('DEP_BANK').
                '-Agência: '.env('DEP_AGENCY').'-'.env('DEP_AGENCY_DIG').
                '-Conta Corrente:'.env('DEP_ACCOUNT').'-'.env('DEP_ACCOUNT_DIG').
                '-Favorecido:'.env('DEP_NAME'),
            'active' => constLang('active_true'),
            'created_at' => $date
        ]);

        ConfigFormPayment::create([
            'method' => 'billet',
            'order' => '02',
            'label' => 'Boleto Bancário',
            'description' => 'Pagamento com boleto.',
            'active' => constLang('active_true'),
            'created_at' => $date
        ]);

        ConfigFormPayment::create([
            'method' => 'credit',
            'order' => '03',
            'label' => 'Cartão de Crédito',
            'description' => 'Pagamento com cartão de crédito',
            'active' => constLang('active_true'),
            'created_at' => $date
        ]);

        ConfigFormPayment::create([
            'method' => 'debit',
            'order' => '04',
            'label' => 'Cartão de Débito',
            'description' => 'Pagamento com cartão de débito.',
            'active' => constLang('active_true'),
            'created_at' => $date
        ]);

    }
}
