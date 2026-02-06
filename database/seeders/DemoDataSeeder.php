<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Category;
use App\Models\Article;
use App\Models\Slider;
use Illuminate\Support\Facades\Hash;

class DemoDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user
        User::create([
            'name' => 'Admin',
            'email' => 'admin@apostolado.com',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'is_admin' => true,
        ]);

        // Create categories
        $categories = [
            ['name' => 'Notícias', 'slug' => 'noticias', 'order' => 1, 'show_in_menu' => true, 'is_active' => true],
            ['name' => 'Sobre Nós', 'slug' => 'sobre-nos', 'order' => 2, 'show_in_menu' => true, 'is_active' => true],
            ['name' => 'Eventos', 'slug' => 'eventos', 'order' => 3, 'show_in_menu' => true, 'is_active' => true],
            ['name' => 'Oração do Mês', 'slug' => 'oracao-do-mes', 'order' => 4, 'show_in_menu' => true, 'is_active' => true],
        ];

        foreach ($categories as $category) {
            Category::create($category);
        }

        // Create sample articles
        $articles = [
            [
                'title' => 'Bem-vindos ao Apostolado da Oração',
                'slug' => 'bem-vindos-ao-apostolado-da-oracao',
                'excerpt' => 'Conheça nossa missão de rezar pelas intenções do Papa e evangelizar através da oração.',
                'content' => 'O Apostolado da Oração é uma rede mundial de oração que une milhões de corações ao Sagrado Coração de Jesus...',
                'category' => 'Notícias',
                'is_published' => true,
                'published_at' => now(),
                'user_id' => 1,
            ],
            [
                'title' => 'Intenções de Oração de Fevereiro',
                'slug' => 'intencoes-de-oracao-de-fevereiro',
                'excerpt' => 'Rezemos pelas intenções do Papa Francisco neste mês.',
                'content' => 'Neste mês de fevereiro, o Papa Francisco nos convida a rezar pela paz mundial...',
                'category' => 'Oração do Mês',
                'is_published' => true,
                'published_at' => now()->subDays(2),
                'user_id' => 1,
            ],
            [
                'title' => 'História do Apostolado da Oração',
                'slug' => 'historia-do-apostolado-da-oracao',
                'excerpt' => 'Descubra como surgiu esta bela obra de evangelização.',
                'content' => 'O Apostolado da Oração nasceu em 1844 na França, com jovens seminaristas jesuítas...',
                'category' => 'Sobre Nós',
                'is_published' => true,
                'published_at' => now()->subDays(5),
                'user_id' => 1,
            ],
        ];

        foreach ($articles as $article) {
            Article::create($article);
        }

        // Note: Sliders need actual images, so we'll create them without images for now
        // Users can add images through the admin panel
        $this->command->info('Demo data created successfully!');
        $this->command->info('Admin user: admin@apostolado.com / password');
    }
}
