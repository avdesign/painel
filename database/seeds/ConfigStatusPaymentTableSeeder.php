<?php

use Illuminate\Database\Seeder;
use AVDPainel\Models\Admin\ConfigStatusPayment;

class ConfigStatusPaymentTableSeeder extends Seeder
{
    /**
     * Table StatusPayment.
     *
     * @return void
     */
    public function run()
    {
        $date = date('Y-m-d H:i:s');


        ConfigStatusPayment::create([
            'order' => 1,
            'status' => 1,
            'type' => 'S',
            'gateway' => 'admin',
            'label' => 'Aguardando Boleto',
            'description' => 'Aguardando até que o Banco confirme a compensação do valor. Os Bancos tem um prazo médio de até 3 dias úteis a partir da data do pagamento do boleto.',
            'active' => constLang('active_true'),
            'created_at' => $date
        ]);

        ConfigStatusPayment::create([
            'order' => 2,
            'status' => 2,
            'type' => 'S',
            'gateway' => 'admin',
            'label' => 'Aguardando Depósito',
            'description' => 'Aguardando a compensação do valor do depósito. Os Bancos tem um prazo médio de até 3 dias úteis.',
            'active' => constLang('active_true'),
            'created_at' => $date
        ]);

        ConfigStatusPayment::create([
            'order' => 3,
            'status' => 3,
            'type' => 'S',
            'gateway' => 'admin',
            'label' => 'Aguardando Pagamento',
            'description' => 'Aguardando a forma de pagamento.',
            'active' => constLang('active_true'),
            'created_at' => $date
        ]);

        ConfigStatusPayment::create([
            'order' => 4,
            'status' => 4,
            'type' => 'S',
            'gateway' => 'admin',
            'label' => 'Cancelado',
            'description' => 'O pedido foi cancelado pelo cliente.',
            'active' => constLang('active_true'),
            'created_at' => $date
        ]);

        ConfigStatusPayment::create([
            'order' => 5,
            'status' => 5,
            'type' => 'S',
            'gateway' => 'admin',
            'label' => 'Desistiu',
            'description' => 'O cliente desistiu do pedido.',
            'active' => constLang('active_true'),
            'created_at' => $date
        ]);

        ConfigStatusPayment::create([
            'order' => 6,
            'status' => 6,
            'type' => 'S',
            'gateway' => 'admin',
            'label' => 'Fraude',
            'description' => 'O pedido foi identificado como fraude.',
            'active' => constLang('active_true'),
            'created_at' => $date
        ]);

        ConfigStatusPayment::create([
            'order' => 7,
            'status' => 7,
            'type' => 'S',
            'gateway' => 'admin',
            'label' => 'Liberado para pagamento',
            'description' => 'O pedido foi liberado para pagamento.',
            'active' => constLang('active_true'),
            'created_at' => $date
        ]);

        ConfigStatusPayment::create([
            'order' => 8,
            'status' => 8,
            'type' => 'S',
            'gateway' => 'admin',
            'label' => 'Pago (boleto)',
            'description' => 'Pagamento através de boleto.',
            'active' => constLang('active_true'),
            'created_at' => $date
        ]);

        ConfigStatusPayment::create([
            'order' => 9,
            'status' => 9,
            'type' => 'S',
            'gateway' => 'admin',
            'label' => 'Pago (depósito)',
            'description' => 'pagamento através de depósito em conta corrente.',
            'active' => constLang('active_true'),
            'created_at' => $date
        ]);

        ConfigStatusPayment::create([
            'order' => 10,
            'status' => 10,
            'type' => 'S',
            'gateway' => 'admin',
            'label' => 'Pago (cartão)',
            'description' => 'pagamento através de cartão de débito ou crédito.',
            'active' => constLang('active_true'),
            'created_at' => $date
        ]);

        ConfigStatusPayment::create([
            'order' => 11,
            'status' => 11,
            'type' => 'S',
            'gateway' => 'admin',
            'label' => 'Suspenso',
            'description' => 'O pedido foi suspenso por falta de pagamento na data prevista.',
            'active' => constLang('active_true'),
            'created_at' => $date
        ]);

        ConfigStatusPayment::create([
            'order' => 12,
            'status' => 12,
            'type' => 'S',
            'gateway' => 'admin',
            'label' => 'Verificando Estoque',
            'description' => 'Verificando a disponibilidade dos produtos no estoque.',
            'active' => constLang('active_true'),
            'created_at' => $date
        ]);
    }
}
