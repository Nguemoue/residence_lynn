<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Subscriber;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

final class NewsletterController extends Controller
{
    public function __construct(private SubscribeNewsletterAction $action) {}

    public function store(NewsletterRequest $request): RedirectResponse
    {
        $this->action->execute($request->toDto());

        return back()->with('success', 'Merci pour votre inscription !');
    }

}
