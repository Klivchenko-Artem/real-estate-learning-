<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Property;
use App\Models\Seo;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class SeoController extends Controller
{
    public function index(): View
    {
        return view('admin.seo.index');
    }

    public function create(): View
    {
        return view('admin.seo.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'url'              => 'required|string|max:500|unique:seos,url',
            'title'            => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        Seo::create($request->only('url', 'title', 'meta_description', 'meta_keywords', 'og_title', 'og_description'));

        return redirect()->route('admin.seo.index')->with('success', 'SEO запись создана.');
    }

    public function edit(Seo $seo): View
    {
        return view('admin.seo.edit', compact('seo'));
    }

    public function update(Request $request, Seo $seo): RedirectResponse
    {
        $request->validate([
            'url'              => 'required|string|max:500|unique:seos,url,' . $seo->id,
            'title'            => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
        ]);

        $seo->update($request->only('url', 'title', 'meta_description', 'meta_keywords', 'og_title', 'og_description'));

        return redirect()->route('admin.seo.index')->with('success', 'SEO запись обновлена.');
    }

    public function destroy(Seo $seo): RedirectResponse
    {
        $seo->delete();
        return redirect()->route('admin.seo.index')->with('success', 'SEO запись удалена.');
    }

    public function datatable(): mixed
    {
        return datatables()
            ->of(Seo::select('*'))
            ->addColumn('actions', fn($s) => view('admin.partials.datatable.actions', [
                'editRoute'   => route('admin.seo.edit', $s),
                'deleteRoute' => route('admin.seo.destroy', $s),
            ])->render())
            ->rawColumns(['actions'])
            ->toJson();
    }

    public function robots(): Response
    {
        $content = Setting::get('robots_txt', "User-agent: *\nAllow: /");
        return response($content, 200)->header('Content-Type', 'text/plain');
    }

    public function robotsEdit(): View
    {
        return view('admin.seo.robots', [
            'robots' => Setting::get('robots_txt', "User-agent: *\nAllow: /"),
        ]);
    }

    public function robotsSave(Request $request): RedirectResponse
    {
        Setting::set('robots_txt', $request->input('robots_txt', ''));
        return back()->with('success', 'Robots.txt обновлён.');
    }

    public function sitemap(): Response
    {
        $properties = Property::where('status', true)->get();
        $content = view('seo.sitemap', compact('properties'))->render();
        return response($content, 200)->header('Content-Type', 'application/xml');
    }
}
