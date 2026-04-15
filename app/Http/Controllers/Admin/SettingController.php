<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function index(): View
    {
        $settings = [
            'hero_title'       => Setting::get('hero_title', 'НАЙДИ СВОЁ ПРОСТРАНСТВО'),
            'hero_subtitle'    => Setting::get('hero_subtitle', 'Премиальная недвижимость для тех, кто ценит стиль'),
            'experience_years' => Setting::get('experience_years', '5'),
            'clients_count'    => Setting::get('clients_count', '120'),
            'phone'            => Setting::get('phone', ''),
            'email'            => Setting::get('email', ''),
            'address'          => Setting::get('address', ''),
        ];

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'hero_title'       => 'nullable|string|max:255',
            'hero_subtitle'    => 'nullable|string|max:500',
            'experience_years' => 'nullable|integer',
            'clients_count'    => 'nullable|integer',
            'phone'            => 'nullable|string|max:50',
            'email'            => 'nullable|email|max:255',
            'address'          => 'nullable|string|max:500',
        ]);

        foreach ($data as $key => $value) {
            Setting::set($key, $value ?? '');
        }

        return back()->with('success', 'Настройки сохранены.');
    }
}
