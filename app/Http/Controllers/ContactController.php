<?php

namespace App\Http\Controllers;

use App\Models\StoreSetting;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function show()
    {
        return view('pages.contacts', [
            'settings' => StoreSetting::query()->where('group', 'contacts')->pluck('value', 'key'),
        ]);
    }

    public function send(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'message' => ['required', 'string', 'max:3000'],
        ]);

        return back()->with('status', 'Спасибо! Менеджер ToyBox свяжется с вами в ближайшее время.');
    }
}
