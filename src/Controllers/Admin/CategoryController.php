<?php

namespace Azuriom\Plugin\Support\Controllers\Admin;

use Azuriom\Http\Controllers\Controller;
use Azuriom\Plugin\Support\Models\Category;
use Azuriom\Plugin\Support\Models\Field;
use Azuriom\Plugin\Support\Requests\CategoryRequest;

class CategoryController extends Controller
{
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('support::admin.categories.create', [
            'fieldTypes' => Field::TYPES,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryRequest $request)
    {
        $category = Category::create($request->validated());

        $category->syncFields($request->input('fields', []));

        return to_route('support.admin.tickets.index')
            ->with('success', trans('messages.status.success'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('support::admin.categories.edit', [
            'category' => $category,
            'fieldTypes' => Field::TYPES,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryRequest $request, Category $category)
    {
        $category->update($request->validated());

        $category->syncFields($request->input('fields', []));

        return to_route('support.admin.tickets.index')
            ->with('success', trans('messages.status.success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @throws \LogicException
     */
    public function destroy(Category $category)
    {
        if (! $category->tickets->isEmpty()) {
            return to_route('support.admin.tickets.index')
                ->with('error', trans('support::admin.categories.delete_empty'));
        }

        $category->delete();

        return to_route('support.admin.tickets.index')
            ->with('success', trans('messages.status.success'));
    }
}
