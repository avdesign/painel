<?php

use Illuminate\Database\Seeder;

use AVDPainel\Models\Admin\User;
use AVDPainel\Models\Admin\Order;
use AVDPainel\Models\Admin\UserAddress;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $id_user  = mt_rand(1, '123456789');
        $id_order = intval(3472017999);
        $date     = date('Y-m-d H:i:s');

        User::create([
            'id' => $id_user,
            'profile_id' => 2,
            'type_id' => 2,
            'first_name' => 'Anselmo',
            'last_name' => 'Velame',
            'email' => 'design@anselmovelame.com.br',
            'document1' => '255.837.435-49',
            'document2' => '27.200.757-2',
            'phone' => '(11) 96938-4849',
            'cell' => '(11) 96938-4849',
            'admin' => '',
            'token' => Null,
            'password' => bcrypt('avdesign'),
            'date' => '07/07/1962',
            'client' => 1,
            'active' => constLang('active_true'),
            'newsletter' => 1,
            'visits' => 0,
            'ip' => '141441414441',
            'last_login' => Null,
            'logout' => Null,
            'created_at' => $date

        ]);

        UserAddress::create([
            'user_id' => $id_user,
            'address' => 'Rua Chico Pontes',
            'number' => '1500',
            'complement' => 'Casa',
            'district' => 'Vila Guilherme',
            'city' => 'São Paulo',
            'state' => 'SP',
            'zip_code' => '03010-000',
            'created_at' => $date
        ]);

        Order::create([
            'id' => $id_order,
            'user_id' => $id_user,
            'config_form_payment_id' => 1,
            'config_status_payment_id' => 1,
            'config_shipping_id' => 1,
            'company' => 1,
            'status_label' => 1,
            'qty' => 1,
            'percent' => 1,
            'price_card' => 1,
            'price_cash' => 1,
            'subtotal' => 1,
            'total' => 1,
            'coupon' => 1,
            'discount' => 1,
            'freight' => 1,
            'tax' => 1,
            'ip' => 1,
            'code' => 1,
            'reference' => 1,
            'ip' => '152.232.209.96',
            'token' => bcrypt($id_order.$id_user),
            'created_at' => $date
        ]);


    }
}
