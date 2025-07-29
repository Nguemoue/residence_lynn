<?php

declare(strict_types=1);

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

final class ContactController extends Controller
{
    public function create(): View
    {
        return view('pages.contact.create');
    }

    public function store(Request $request): RedirectResponse
    {
        Contact::create(
            $request->validate([
                'name'    => ['required','string','max:100'],
                'email'   => ['required','email'],
                'subject' => ['required','string','max:150'],
                'message' => ['required','string','max:5000'],
            ])
        );

        return back()->with('success', 'Message envoyé, merci !');
    }
}
