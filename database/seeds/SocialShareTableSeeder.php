<?php

use Illuminate\Database\Seeder;
use AVDPainel\Models\Admin\SocialShare;

class SocialShareTableSeeder extends Seeder
{
    /**
     * Config social share.
     *
     * @return void
     */
    public function run()
    {
        SocialShare::create([
            'name' => 'facebook',
            'share' => 'https://www.facebook.com/sharer/sharer.php?u=',
            'link' => 'https://www.facebook.com/anselmo.velame.9',
            'active' => constLang('active_false')
        ]);

        SocialShare::create([
            'name' => 'twitter',
            'share' => 'https://twitter.com/intent/tweet?url=',
            'link' => '',
            'active' => constLang('active_false')
        ]);

        SocialShare::create([
            'name' => 'instagram',
            'share' => '',
            'link' => '',
            'active' => constLang('active_false')
        ]);


        SocialShare::create([
            'name' => 'pinterest',
            'share' => 'https://pinterest.com/pin/create/button/?url=',
            'link' => '',
            'active' => constLang('active_false')
        ]);

        SocialShare::create([
            'name' => 'linkedin',
            'share' => 'https://www.linkedin.com/shareArticle?mini=true&amp;url=',
            'link' => '',
            'active' => constLang('active_false')
        ]);

        SocialShare::create([
            'name' => 'email',
            'share' => '',
            'link' => '',
            'active' => constLang('active_false')
        ]);


    }
}

