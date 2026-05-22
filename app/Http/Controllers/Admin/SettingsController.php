<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StoreSetting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function edit()
    {
        return view('admin.settings.edit', [
            'settings' => StoreSetting::query()->pluck('value', 'key'),
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'store_name' => ['required', 'string', 'max:255'],
            'manager_phone' => ['required', 'string', 'max:50'],
            'display_phone' => ['required', 'string', 'max:50'],
            'email' => ['required', 'email', 'max:255'],
            'address' => ['required', 'string', 'max:500'],
            'work_hours' => ['required', 'string', 'max:255'],
            'mission' => ['required', 'string', 'max:1000'],
        ]);

        foreach ($data as $key => $value) {
            StoreSetting::query()->updateOrCreate(
                ['key' => $key],
                ['value' => $value, 'group' => in_array($key, ['mission'], true) ? 'about' : 'contacts'],
            );
        }

        return back()->with('status', 'Настройки магазина сохранены.');
    }
}
