<?php

namespace Modules\Category\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Category\Entities\Category;
use CodeZero\UniqueTranslation\UniqueTranslationRule;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index(Request $request)
    {
        $categories = Category::when($request->search, function ($query) use ($request) {
            return $query->where('name', 'like', '%' . $request->search . '%');
        })->latest()->paginate(5);

        return view('category::index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $categories = Category::all();
        return view('category::create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $request)
    {

        $rules = [];

        foreach (config('laravellocalization.supportedLocales') as $locale => $langDetails) {
            $rules += ['name.' . $locale => ['required', 'max:255', UniqueTranslationRule::for('categories', 'name')]];
            $rules += ['description.' . $locale => ['required', 'max:255']];
        }

        $rules += ['image' => ['image', 'mimes:jpeg,png,jpg,gif,svg,max:2048']];

        // validation
        $request->validate($rules);

        // image
        if ($request->has('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/categories'), $imageName);
        } else {
            $imageName = 'default.jpg';
        }


        $category = new Category(); // This is an Eloquent model

        $category->parent_id = $request->parent_id; // parent_id

        foreach (config('laravellocalization.supportedLocales') as $locale => $langDetails) {
            $category
                ->setTranslation('name', $locale, $request->name[$locale])
                ->setTranslation('description', $locale, $request->description[$locale]);
        }

        $category->image = $imageName;
        $category->save();


        if ($category) {
            return redirect()->route('dashboard.categories.index')->with('success', __('admin::site.added_successfully'));
        } else {
            return redirect()->back()->with('error', __('admin::site.added_failed'));
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('category::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit(Category $category)
    {
        $categories = Category::all();

        return view('category::edit', compact('category', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, Category $category)
    {
        $rules = [];

        foreach (config('laravellocalization.supportedLocales') as $locale => $langDetails) {
            $rules += ['name.' . $locale => ['required', 'max:255', UniqueTranslationRule::for('categories', 'name')->ignore($category->id)]];
            $rules += ['description.' . $locale => ['required', 'max:255']];
        }

        $rules += ['image' => ['image', 'mimes:jpeg,png,jpg,gif,svg,max:2048']];

        // validation
        $request->validate($rules);

        // image
        if ($request->has('image')) {

            // delete old image
            if ($category->image != 'default.jpg') {
                Storage::disk('public_uploads')->delete('categories/' . $category->image);
            }

            // insert new image
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(public_path('uploads/categories'), $imageName);

            $request['imageName'] =  $imageName;
        } else {
            $request['imageName'] = 'default.jpg';
        }

        $category->parent_id = $request->parent_id; // parent_id

        foreach (config('laravellocalization.supportedLocales') as $locale => $langDetails) {
            $category
                ->setTranslation('name', $locale, $request->name[$locale])
                ->setTranslation('description', $locale, $request->description[$locale]);
        }

        $category->image = $request->imageName;
        $category->save();


        if ($category) {
            return redirect()->route('dashboard.categories.index')->with('success', __('admin::site.updated_successfully'));
        } else {
            return redirect()->back()->with('error', __('admin::site.updated_failed'));
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy(Category $category)
    {
        if ($category->image != 'default.jpg') {
            Storage::disk('public_uploads')->delete('categories/' . $category->image);
        }

        $category->delete();
        return redirect()->route('dashboard.categories.index')->with('success', __('site.deleted_successfully'));
    }
}
