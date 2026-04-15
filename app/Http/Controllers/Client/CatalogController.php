<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\PropertyService;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Inertia\Response;

class CatalogController extends Controller
{
    public function __construct(private PropertyService $propertyService) {}

    public function index(Request $request): Response
    {
        $properties = $this->propertyService->getFiltered($request);

        return Inertia::render('Catalog', [
            'properties' => $properties,
            'categories' => Category::orderBy('position')->get(['id', 'name', 'slug']),
            'filters'    => $request->only(['category', 'price_min', 'price_max', 'area_min', 'area_max', 'rooms']),
            'priceRange' => [
                'min' => (int) \App\Models\Property::where('status', true)->min('price') ?? 0,
                'max' => (int) \App\Models\Property::where('status', true)->max('price') ?? 10000000,
            ],
        ]);
    }
}
