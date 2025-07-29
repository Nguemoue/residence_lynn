<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Domain\Contracts\PostRepositoryContract;
use App\Domain\Contracts\ProductRepositoryContract;
use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;

final class BlogController extends Controller
{
    public function __construct(
        private readonly PostRepositoryContract     $posts,
        private readonly ProductRepositoryContract $products,
    ) {}
    public function index(): View
    {
        $posts = Post::query()
            ->where('is_published', true)
            ->latest('published_at')
            ->paginate(6);

        return view('pages.blog.index', compact('posts'));
    }

    /**
     * Affiche un article de blog.
     */
    public function show(string $slug): View
    {
        /** @var Post $post */
        $post = $this->posts->findPublishedBySlug($slug);

        abort_if(! $post, 404);

        // Incrément de la vue (éventuellement via événement/observer)
        $post->increment('views');

        // Table des matières (H2 / H3) ➜ [id => texte]
        $toc = $this->buildToc($post->content);

        // Produits associés (ex : par tags ou catégorie)
        $relatedProducts = $this->products->findRecommendedForPost($post, 2); // méthode à prévoir dans ton repo produit

        return view('pages.blog.show', [
            'post'            => $post,
            'toc'             => $toc,
            'related'         => $this->posts->related($post),
            'recentPosts'     => $this->posts->recent(),
            'relatedProducts' => $relatedProducts,
        ]);
    }

    /**
     * Construit un mini sommaire basé sur les balises <h2>/<h3> déjà présentes
     * dans le HTML stocké (issu du Markdown, par ex.).
     *
     * @return array<string,string> [anchor => texte]
     */
    private function buildToc(string $html): array
    {
        /** @var array<string,string> $toc */
        $toc = [];

        // On utilise DOMDocument pour extraire les titres
        $dom = new \DOMDocument();
        @$dom->loadHTML('<?xml encoding="utf-8" ?>' . $html);

        /** @var \DOMElement $node */
        foreach ($dom->getElementsByTagName('*') as $node) {
            if (! in_array($node->tagName, ['h2', 'h3'], true)) {
                continue;
            }

            $text   = trim($node->textContent);
            $anchor = Str::slug(Str::limit($text, 60));

            $toc[$anchor] = $text;

            // Ajoute l’id au nœud si absent (pour permettre le scroll)
            if (! $node->hasAttribute('id')) {
                $node->setAttribute('id', $anchor);
            }
        }

        // Ré-injecte les id modifiés dans l’objet Post si besoin
        // (ici on renvoie seulement le tableau, le HTML modifié est ignoré
        // parce que le Markdown originel a déjà été rendu avec des ids)

        return $toc;
    }
}
