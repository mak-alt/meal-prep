<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Pages\DeleteFileRequest;
use App\Http\Requests\Backend\Pages\UpdatePageRequest;
use App\Models\Meal;
use App\Models\Menu;
use App\Models\Page;
use App\Models\WeeklyMenu;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class PageController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): View
    {
        $pages = Page::latest()->get(['id', 'name', 'slug', 'title', 'status']);

        return \view('backend.pages.index', compact('pages'));
    }

    /**
     * @param \App\Models\Page $page
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Page $page): View
    {
        if ($page->name === 'weeklyMenu') {
            $page->weeklyMenus  = WeeklyMenu::paginate(15);
        }

        return \view('backend.pages.edit', compact('page'));
    }

    /**
     * @param \App\Http\Requests\Backend\Pages\UpdatePageRequest $request
     * @param \App\Models\Page $page
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse
     */
    public function update(UpdatePageRequest $request, Page $page)
    {
        try {
            $page->updatePage($request->except(['_token', '_method']));
        } catch (\Throwable $exception) {
            if ($request->ajax()) {
                return response()->json($this->formatResponse('error', 'Page update failed.'), 400);
            }

            return redirect()->back()->with('error', 'Page update failed.');
        }

        if ($request->ajax()) {
            return response()->json($this->formatResponse('success', 'Page has been successfully updated.'));
        }

        return redirect()->back()->with('success', 'Page has been successfully updated.');
    }

    /**
     * @param \App\Http\Requests\Backend\Pages\DeleteFileRequest $request
     * @param \App\Models\Page $page
     * @return \Illuminate\Http\JsonResponse
     */
    public function deleteFile(DeleteFileRequest $request, Page $page): JsonResponse
    {
        if ($request->ajax()) {
            try {
                $page->deleteDataFile($request->path, $request->key);
            } catch (\Throwable $exception) {
                return response()->json($this->formatResponse('error', 'File deletion failed.'), 400);
            }

            return response()->json($this->formatResponse('success', 'File has been successfully deleted.'));
        }
    }
}
