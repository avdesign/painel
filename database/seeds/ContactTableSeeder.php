<?php

use Illuminate\Database\Seeder;

use AVDPainel\Models\Admin\Contact;

class ContactTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $id = mt_rand(1, '86420895');

        Contact::create([
            'id' => $id,
            'subject_id' => 1,
            'user_id' => 0,
            'subject' => 'Sobre compras',
            'name' => 'Anselmo',
            'email' => 'design@anselmovelame.com.br',
            'cell' => '(11)96938-4849',
            'type' => 'V',
            'message' => 'Mensagem de teste',
            'return' => '',
            'ip' => '127.0.1.1.1',
            'city' => 'São Paulo',
            'state' => 'SP',
            'zip_code' => '03010.000',
            'latitude' => '',
            'longitude' => '',
            'admin' => 'Anselmo',
            'send' => 0,
            'client' => 0,
            'status' => 1
        ]);



    }
}
