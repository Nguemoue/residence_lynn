<?php

declare(strict_types=1);

namespace App\Livewire\Blog;

use App\Models\Post;
use App\Models\PostCategory;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

final class ListPosts extends Component
{
    use WithPagination;

    #[Url(except: '')]   // ← garde la synchro d’URL sans paramètre quand null
    public ?string $category = null;

    public int $perPage = 6;

    /* ---------------------------------------------------------- */
    /*  PROPRIÉTÉS COMPUTED                                       */
    /* ---------------------------------------------------------- */

    /** Collection paginée des posts filtrés. */
    public function getPostsProperty()
    {
        return Post::published()
            ->with('category')
            ->when($this->category, fn (Builder $q) =>
            $q->whereHas(
                'category',
                fn (Builder $c) => $c->where('slug', $this->category)
            )
            )
            ->orderByDesc('published_at')
            ->paginate($this->perPage);
    }

    /** Catégories pour les filtres. */
    public function getCategoriesProperty()
    {
        return PostCategory::orderBy('name')->get();
    }

    /* ---------------------------------------------------------- */
    /*  ACTIONS                                                   */
    /* ---------------------------------------------------------- */

    public function loadMore(): void
    {
        $this->perPage += 6;
    }

    public function render()
    {
        return view('livewire.blog.list-posts', [
            'posts'      => $this->posts,      // computed property
            'categories' => $this->categories, // computed property
        ]);
    }
}
