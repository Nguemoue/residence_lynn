<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

final class TestimonialsSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            [
                'content' => 'Un accueil chaleureux, un logement impeccable et une vue à couper le souffle. Kribi comme on l’aime !',
                'author' => 'Isabelle T.',
                'location' => 'Yaoundé',
            ],
            [
                'content' => 'Super service, bon rapport qualité-prix, et à deux minutes de la plage. Recommandé à 100%.',
                'author' => 'Alain K.',
                'location' => 'Douala',
            ],
            [
                'content' => 'On reviendra ! La réservation était facile, et le cadre apaisant. Merci pour tout.',
                'author' => 'Mireille N.',
                'location' => 'Libreville',
            ],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::updateOrCreate(
                ['author' => $testimonial['author']], // critère d’unicité
                $testimonial // données à insérer ou mettre à jour
            );
        }
    }
}
