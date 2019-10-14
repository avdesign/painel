<?php

use Illuminate\Database\Seeder;
use AVDPainel\Models\Admin\ContentPrivacyPolicy;

class ContentPrivacyPoliciesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $date = date('Y-m-d H:i:s');
        ContentPrivacyPolicy::create([
            'type' => 'header',
            'title' => 'QUE DADOS PESSOAIS COLETAMOS E POR QUE NÓS COLETAMOS',
            'description' => '',
            'order' => 01,
            'active' => constLang('active_true'),
            'created_at' => $date
        ]);

        ContentPrivacyPolicy::create([
            'type' => 'content',
            'title' => 'COMENTÁRIOS',
            'description' => 'Quando os visitantes deixam comentários no site, coletamos os dados mostrados no formulário de comentários e também o endereço IP do visitante e a string do agente do usuário do navegador para ajudar na detecção de spam.Uma string anonimizada criada a partir do seu endereço de e-mail (também chamado de hash) pode ser fornecida ao serviço Gravatar para ver se você está usando. Após a aprovação do seu comentário, a foto do seu perfil ficará visível para o público no contexto do seu comentário.',
            'order' => 01,
            'active' => constLang('active_true'),
            'created_at' => $date
        ]);

        ContentPrivacyPolicy::create([
            'type' => 'content',
            'title' => 'MÍDIA',
            'description' => 'Se você fizer upload de imagens para o site, evite o upload de imagens com dados de localização incorporados (GPS EXIF) incluídos. Os visitantes do site podem baixar e extrair quaisquer dados de localização de imagens no site.',
            'order' => 02,
            'active' => constLang('active_true'),
            'created_at' => $date
        ]);

        ContentPrivacyPolicy::create([
            'type' => 'content',
            'title' => 'FORMULÁRIOS DE CONTATO',
            'description' => 'Se você deixar um comentário em nosso site, você pode optar por salvar seu nome, endereço de e-mail e site em cookies. Estes são para sua conveniência, para que você não precise preencher seus dados novamente quando deixar outro comentário. Esses cookies durarão um ano.Se você tiver uma conta e fizer login neste site, definiremos um cookie temporário para determinar se seu navegador aceita cookies. Este cookie não contém dados pessoais e é descartado quando você fecha o navegador.Quando você fizer login, também configuraremos vários cookies para salvar suas informações de login e suas opções de exibição na tela. Os cookies de login duram dois dias e os cookies de opções de tela duram um ano. Se você selecionar "Lembrar de Mim", seu login persistirá por duas semanas. Se você sair da sua conta, os cookies de login serão removidos.Se você editar ou publicar um artigo, um cookie adicional será salvo no seu navegador. Este cookie não inclui dados pessoais e simplesmente indica o ID do post que você acabou de editar. Expira após 1 dia.',
            'order' => 03,
            'active' => constLang('active_true'),
            'created_at' => $date
        ]);

        ContentPrivacyPolicy::create([
            'type' => 'content',
            'title' => 'CONTEÚDO EMBUTIDO DE OUTROS WEBSITES',
            'description' => 'Os artigos deste site podem incluir conteúdo incorporado (por exemplo, vídeos, imagens, artigos, etc.). O conteúdo incorporado de outros sites se comporta da mesma maneira como se o visitante tivesse visitado o outro site.Esses sites podem coletar dados sobre você, usar cookies, incorporar rastreamento adicional de terceiros e monitorar sua interação com o conteúdo incorporado, incluindo rastrear sua interação com o conteúdo incorporado se você tiver uma conta e estiver conectado a esse site.',
            'order' => 04,
            'active' => constLang('active_true'),
            'created_at' => $date
        ]);

        ContentPrivacyPolicy::create([
            'type' => 'content',
            'title' => 'Quanto tempo retemos seus dados',
            'description' => 'Se você deixar um comentário, o comentário e seus metadados serão retidos indefinidamente. Isso é para que possamos reconhecer e aprovar quaisquer comentários de acompanhamento automaticamente, em vez de mantê-los em uma fila de moderação.Para usuários que se registram em nosso site (se houver), também armazenamos as informações pessoais que eles fornecem em seu perfil de usuário.Todos os usuários podem ver, editar ou excluir suas informações pessoais a qualquer momento (exceto que não podem alterar seu nome de usuário).Administradores de sites também podem ver e editar essas informações.',
            'order' => 05,
            'active' => constLang('active_true'),
            'created_at' => $date
        ]);

        ContentPrivacyPolicy::create([
            'type' => 'content',
            'title' => 'QUE DIREITOS TÊM SOBRE OS SEUS DADOS?',
            'description' => 'Se você tiver uma conta neste site ou tiver deixado comentários, poderá solicitar o recebimento de um arquivo exportado dos dados pessoais que mantemos sobre você, incluindo todos os dados que você nos forneceu.Você também pode solicitar que apague quaisquer dados pessoais que tenhamos sobre você. Isso não inclui quaisquer dados que somos obrigados a manter para fins administrativos, legais ou de segurança.',
            'order' => 06,
            'active' => constLang('active_true'),
            'created_at' => $date
        ]);


        ContentPrivacyPolicy::create([
            'type' => 'content',
            'title' => 'ONDE ENVIAMOS SEUS DADOS',
            'description' => 'Os comentários dos visitantes podem ser verificados através de um serviço automatizado de detecção de spam.',
            'order' => 07,
            'active' => constLang('active_true'),
            'created_at' => $date
        ]);

    }
}
