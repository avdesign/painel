<?php

use Illuminate\Database\Seeder;
use AVDPainel\Models\Admin\PaymentCompany;

class PaymentCompanyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        PaymentCompany::create([
            'name' => 'PagSeguro',
            'slug' => 'pagseguro',
            'billet' => 1,
            'cash' => 0,
            'credit' => 1,
            'debit' => 1
        ]);

        PaymentCompany::create([
            'name' => 'Bradesco',
            'slug' => 'bradesco',
            'billet' => 0,
            'cash' => 1,
            'credit' => 0,
            'debit' => 0
        ]);
    }
}
