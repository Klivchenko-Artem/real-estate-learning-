<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Setting;
use App\Services\PropertyService;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function __construct(private PropertyService $propertyService) {}

    public function __invoke(): Response
    {
        return Inertia::render('Home', [
            'featured'   => $this->propertyService->getFeatured(6),
            'categories' => Category::orderBy('position')->get(['id', 'name', 'slug']),
            'stats'      => [
                'properties' => \App\Models\Property::where('status', true)->count(),
                'categories' => Category::count(),
                'experience' => (int) Setting::get('experience_years', 5),
                'clients'    => (int) Setting::get('clients_count', 120),
            ],
            'hero' => [
                'title'    => Setting::get('hero_title', 'НАЙДИ СВОЁ ПРОСТРАНСТВО'),
                'subtitle' => Setting::get('hero_subtitle', 'Премиальная недвижимость для тех, кто ценит стиль'),
            ],
        ]);
    }
}
