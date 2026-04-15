<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Property;
use App\Services\PropertyService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PropertyController extends Controller
{
    public function __construct(private PropertyService $propertyService) {}

    public function index(): View
    {
        return view('admin.properties.index');
    }

    public function create(): View
    {
        return view('admin.properties.create', [
            'categories' => Category::orderBy('position')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'              => 'required|string|max:255',
            'short_description' => 'nullable|string|max:500',
            'description'       => 'nullable|string',
            'category_id'       => 'required|exists:categories,id',
            'price'             => 'required|integer|min:0',
            'area'              => 'required|numeric|min:0',
            'rooms'             => 'nullable|integer|min:0',
            'floor'             => 'nullable|integer|min:0',
            'floors_total'      => 'nullable|integer|min:0',
            'address'           => 'nullable|string|max:500',
            'image'             => 'nullable|image|max:10240',
            'status'            => 'boolean',
            'is_featured'       => 'boolean',
            'alias'             => 'nullable|string|max:255|unique:properties,alias',
            'position'          => 'nullable|integer',
        ]);

        $this->propertyService->store($data);

        return redirect()->route('admin.properties.index')->with('success', 'Объект добавлен.');
    }

    public function edit(Property $property): View
    {
        return view('admin.properties.edit', [
            'property'   => $property,
            'categories' => Category::orderBy('position')->get(),
        ]);
    }

    public function update(Request $request, Property $property): RedirectResponse
    {
        $data = $request->validate([
            'name'              => 'required|string|max:255',
            'short_description' => 'nullable|string|max:500',
            'description'       => 'nullable|string',
            'category_id'       => 'required|exists:categories,id',
            'price'             => 'required|integer|min:0',
            'area'              => 'required|numeric|min:0',
            'rooms'             => 'nullable|integer|min:0',
            'floor'             => 'nullable|integer|min:0',
            'floors_total'      => 'nullable|integer|min:0',
            'address'           => 'nullable|string|max:500',
            'image'             => 'nullable|image|max:10240',
            'status'            => 'boolean',
            'is_featured'       => 'boolean',
            'alias'             => 'nullable|string|max:255|unique:properties,alias,' . $property->id,
            'position'          => 'nullable|integer',
        ]);

        $this->propertyService->update($property, $data);

        return redirect()->route('admin.properties.index')->with('success', 'Объект обновлён.');
    }

    public function destroy(Property $property): RedirectResponse
    {
        $this->propertyService->destroy($property);
        return redirect()->route('admin.properties.index')->with('success', 'Объект удалён.');
    }

    public function datatable(): mixed
    {
        return datatables()
            ->of(Property::with('category')->select('properties.*'))
            ->addColumn('category_name', fn($p) => $p->category?->name ?? '—')
            ->addColumn('actions', fn($p) => view('admin.partials.datatable.actions', [
                'editRoute'    => route('admin.properties.edit', $p),
                'deleteRoute'  => route('admin.properties.destroy', $p),
            ])->render())
            ->rawColumns(['actions'])
            ->toJson();
    }
}
