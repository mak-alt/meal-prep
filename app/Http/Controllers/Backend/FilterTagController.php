<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\TagRequest;
use App\Models\Tag;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class FilterTagController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): View
    {
        $tags = Tag::paginate(15);

        return \view('backend.filter-tags.index', compact('tags'));
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function create(): View
    {
        return \view('backend.filter-tags.create');
    }

    /**
     * @param \App\Http\Requests\Backend\TagRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(TagRequest $request): RedirectResponse
    {
        try {
            Tag::create($request->validated());

            return redirect()->back()->with('success', 'Tag has been successfully created.');
        } catch (\Throwable $exception) {
            return redirect()->back()->with('error', 'Tag creation failed.')->withInput();
        }
    }

    /**
     * @param \App\Models\Tag $tag
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Tag $tag): View
    {
        return \view('backend.filter-tags.edit', compact('tag'));
    }

    /**
     * @param \App\Http\Requests\Backend\TagRequest $request
     * @param \App\Models\Tag $tag
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(TagRequest $request, Tag $tag): RedirectResponse
    {
        try {
            $tag->update($request->validated());

            return redirect()->back()->with('success', 'Tag has been successfully updated.');
        } catch (\Throwable $exception) {
            return redirect()->back()->with('error', 'Tag update failed.')->withInput();
        }
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Tag $tag
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, Tag $tag): JsonResponse
    {
        try {
            if ($request->ajax()) {
                $tag->delete();

                return response()->json($this->formatResponse('success', 'Tag has been successfully deleted.'));
            }
        } catch (\Throwable $exception) {
            return response()->json($this->formatResponse('error', 'Tag deletion failed.'), 400);
        }
    }

}
