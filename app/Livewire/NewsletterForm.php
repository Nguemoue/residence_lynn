<?php

namespace App\Livewire;

use App\Models\Subscriber;
use Illuminate\Support\Facades\Validator;
use Livewire\Component;

class NewsletterForm extends Component
{

    public int $design = 1;
    public string $email = '';

    public function subscribe(): void
    {
        $this->validate([
            'email' => ['required', 'email', 'max:255'],
        ]);

        // Ici tu peux stocker l’email ou envoyer à un service tiers
        if (Subscriber::query()->where('email', $this->email)->exists()){
            flash()->info(title:"Deja inscrit!",message: "Cette adresse email est deja presente sur notre newsletter!");
            return;
        }
        Subscriber::query()->create([
            'email'=>$this->email,
            'subscribed_at'=>now()
        ]);
        // Newsletter::create(['email' => $this->email]);
        flash()->success(message: 'Merci pour votre inscription à notre newsletter !', title: 'success');

        $this->reset('email');
    }

    public function render(): \Illuminate\Contracts\View\View
    {
        return view('livewire.newsletter-form');
    }
}
