<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Services\CategoryService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function __construct(private CategoryService $categoryService) {}

    public function index(): View
    {
        return view('admin.categories.index');
    }

    public function create(): View
    {
        return view('admin.categories.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'slug'     => 'nullable|string|max:255|unique:categories,slug',
            'position' => 'nullable|integer',
        ]);

        $this->categoryService->store($data);

        return redirect()->route('admin.categories.index')->with('success', 'Категория создана.');
    }

    public function edit(Category $category): View
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category): RedirectResponse
    {
        $data = $request->validate([
            'name'     => 'required|string|max:255',
            'slug'     => 'nullable|string|max:255|unique:categories,slug,' . $category->id,
            'position' => 'nullable|integer',
        ]);

        $this->categoryService->update($category, $data);

        return redirect()->route('admin.categories.index')->with('success', 'Категория обновлена.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        $this->categoryService->destroy($category);
        return redirect()->route('admin.categories.index')->with('success', 'Категория удалена.');
    }

    public function datatable(): mixed
    {
        return datatables()
            ->of(Category::withCount('properties'))
            ->addColumn('actions', fn($c) => view('admin.partials.datatable.actions', [
                'editRoute'   => route('admin.categories.edit', $c),
                'deleteRoute' => route('admin.categories.destroy', $c),
            ])->render())
            ->rawColumns(['actions'])
            ->toJson();
    }
}
