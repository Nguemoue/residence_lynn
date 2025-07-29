@props(['faqs'])

<section {{$attributes->merge(['class'=>"py-16 bg-base-200"])}}>
    <div class="container mx-auto px-4 max-w-5xl">
        <div class="text-center mb-10">
            <h2 class="text-3xl font-bold text-primary">Foire aux Questions</h2>
            <p class="text-base-content max-w-2xl mx-auto mt-4">
                Toutes les réponses à vos questions sur nos produits et services
            </p>
        </div>

        @if($faqs->isEmpty())
            <p class="text-center text-lg">Aucune question disponible pour le moment.</p>
        @else
            <div class="join join-vertical w-full">
                @foreach($faqs as $faq)
                    <div class="collapse collapse-arrow join-item border border-base-300">
                        <input type="radio" name="faq" {{ $loop->first ? 'checked' : '' }} />
                        <div class="collapse-title font-bold">{{ $faq->question }}</div>
                        <div class="collapse-content prose max-w-none">{{str($faq->answer)->toHtmlString() }}</div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</section>
