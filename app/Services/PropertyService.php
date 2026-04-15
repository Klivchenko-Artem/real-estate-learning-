<?php

namespace App\Services;

use App\Models\Property;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Str;

class PropertyService
{
    public function getFiltered(Request $request): LengthAwarePaginator
    {
        $query = Property::with('category')->where('status', true);

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('price_min')) {
            $query->where('price', '>=', $request->price_min);
        }

        if ($request->filled('price_max')) {
            $query->where('price', '<=', $request->price_max);
        }

        if ($request->filled('area_min')) {
            $query->where('area', '>=', $request->area_min);
        }

        if ($request->filled('area_max')) {
            $query->where('area', '<=', $request->area_max);
        }

        if ($request->filled('rooms')) {
            $query->where('rooms', $request->rooms);
        }

        return $query->orderBy('position')->paginate(12);
    }

    public function getFeatured(int $limit = 6): array
    {
        return Property::with('category')
            ->where('status', true)
            ->where('is_featured', true)
            ->orderBy('position')
            ->take($limit)
            ->get()
            ->toArray();
    }

    public function store(array $data): Property
    {
        if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
            $data['image'] = $data['image']->store('properties', 'public');
        }

        if (empty($data['alias'])) {
            $data['alias'] = Str::slug($data['name']) . '-' . Str::random(6);
        }

        return Property::create($data);
    }

    public function update(Property $property, array $data): Property
    {
        if (isset($data['image']) && $data['image'] instanceof \Illuminate\Http\UploadedFile) {
            $data['image'] = $data['image']->store('properties', 'public');
        }

        $property->update($data);
        return $property;
    }

    public function destroy(Property $property): void
    {
        $property->delete();
    }
}
