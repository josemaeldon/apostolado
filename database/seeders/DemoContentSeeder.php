<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Page;
use App\Models\PrayerIntention;
use App\Models\Article;
use App\Models\Event;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class DemoContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Criar usuário administrador
        $admin = User::create([
            'name' => 'Administrador',
            'email' => 'admin@apostolado.com',
            'password' => Hash::make('password'),
            'is_admin' => true,
            'email_verified_at' => now(),
        ]);

        // Criar páginas
        Page::create([
            'title' => 'Sobre o Apostolado da Oração',
            'slug' => 'sobre',
            'content' => '<p>O Apostolado da Oração é uma Obra Pontifícia e global de espiritualidade, que mobiliza os católicos através da oração e da ação, em comunhão com a missão de Cristo e do Papa para enfrentar os desafios mais importantes da Igreja e do mundo.</p><p>Fundado em 1844, o Apostolado da Oração está presente em mais de 90 países e reúne milhões de pessoas em oração pelas intenções mensais do Papa.</p>',
            'excerpt' => 'Uma Obra Pontifícia e global de espiritualidade que mobiliza católicos em oração.',
            'is_published' => true,
            'order' => 1,
            'user_id' => $admin->id,
        ]);

        Page::create([
            'title' => 'Nossa Missão',
            'slug' => 'missao',
            'content' => '<p>Nossa missão é mobilizar os católicos para a oração e para uma resposta aos desafios da humanidade e da missão da Igreja, propostos pelo Papa em suas intenções mensais.</p><p>Vivemos nossa espiritualidade centrada no Sagrado Coração de Jesus, fonte de amor e misericórdia.</p>',
            'excerpt' => 'Mobilizar católicos para a oração pelas intenções do Papa.',
            'is_published' => true,
            'order' => 2,
            'user_id' => $admin->id,
        ]);

        // Criar intenções de oração
        PrayerIntention::create([
            'title' => 'Pelos Evangelizadores',
            'description' => 'Rezemos para que todos os batizados sejam comprometidos com a evangelização, disponíveis para a missão, através do testemunho de vida conforme ao Evangelho.',
            'month' => 'janeiro',
            'year' => 2026,
            'is_published' => true,
            'user_id' => $admin->id,
        ]);

        PrayerIntention::create([
            'title' => 'Pelo Fim do Tráfico Humano',
            'description' => 'Rezemos para que se possa erradicar o tráfico de pessoas, forma moderna de escravidão, e dar apoio e proteção às vítimas.',
            'month' => 'fevereiro',
            'year' => 2026,
            'is_published' => true,
            'user_id' => $admin->id,
        ]);

        // Criar artigos/notícias
        Article::create([
            'title' => 'Papa Francisco convida jovens para a oração',
            'slug' => 'papa-francisco-jovens-oracao',
            'content' => '<p>Em sua mensagem mensal, o Papa Francisco convidou os jovens a se unirem em oração pelas intenções da Igreja e do mundo.</p><p>"A oração é a força que move o coração de Deus", disse o Santo Padre.</p>',
            'excerpt' => 'Papa Francisco convida jovens a se unirem em oração.',
            'category' => 'Notícias',
            'is_published' => true,
            'published_at' => now(),
            'user_id' => $admin->id,
        ]);

        Article::create([
            'title' => 'O Sagrado Coração de Jesus: Fonte de Amor',
            'slug' => 'sagrado-coracao-jesus',
            'content' => '<p>A devoção ao Sagrado Coração de Jesus é fundamental para a espiritualidade do Apostolado da Oração.</p><p>O Coração de Jesus é símbolo do amor infinito de Deus pela humanidade.</p>',
            'excerpt' => 'Entenda a importância da devoção ao Sagrado Coração.',
            'category' => 'Espiritualidade',
            'is_published' => true,
            'published_at' => now()->subDays(3),
            'user_id' => $admin->id,
        ]);

        // Criar eventos
        Event::create([
            'title' => 'Encontro Mensal de Oração',
            'slug' => 'encontro-mensal-oracao',
            'description' => 'Encontro mensal do Apostolado da Oração para rezarmos juntos pelas intenções do Papa Francisco.',
            'location' => 'Paróquia São José - Rua das Flores, 123',
            'start_date' => now()->addDays(15)->setTime(19, 0),
            'end_date' => now()->addDays(15)->setTime(21, 0),
            'is_published' => true,
            'user_id' => $admin->id,
        ]);

        Event::create([
            'title' => 'Retiro Espiritual',
            'slug' => 'retiro-espiritual',
            'description' => 'Retiro espiritual sobre a espiritualidade do Sagrado Coração de Jesus.',
            'location' => 'Casa de Retiros Nossa Senhora - Serra da Mantiqueira',
            'start_date' => now()->addDays(30)->setTime(9, 0),
            'end_date' => now()->addDays(32)->setTime(17, 0),
            'is_published' => true,
            'user_id' => $admin->id,
        ]);

        $this->command->info('Conteúdo de demonstração criado com sucesso!');
        $this->command->info('Usuário admin: admin@apostolado.com');
        $this->command->info('Senha: password');
    }
}

