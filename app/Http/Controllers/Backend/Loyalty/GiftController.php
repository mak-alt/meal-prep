<?php

namespace App\Http\Controllers\Backend\Loyalty;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Loyalty\Gifts\StoreGiftRequest;
use App\Http\Requests\Backend\Loyalty\Gifts\UpdateGiftRequest;
use App\Models\Gift;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class GiftController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): View
    {
        $gifts = Gift::latest()->paginate(15);

        return \view('backend.gifts.index', compact('gifts'));
    }

    /**
     * @param \App\Models\Gift $gift
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Gift $gift): View
    {
        return \view('backend.gifts.edit', compact('gift'));
    }

    /**
     * @param \App\Http\Requests\Backend\Loyalty\Gifts\UpdateGiftRequest $request
     * @param \App\Models\Gift $gift
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateGiftRequest $request, Gift $gift): RedirectResponse
    {
        try {
            $gift->updateGift($request->validated());

            return redirect()->back()->with('success', 'Gift has been successfully updated.');
        } catch (\Throwable $exception) {
            return redirect()->back()->with('error', 'Gift update failed.')->withInput();
        }
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function create(): View
    {
        return \view('backend.gifts.create');
    }

    /**
     * @param \App\Http\Requests\Backend\Loyalty\Gifts\StoreGiftRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreGiftRequest $request): RedirectResponse
    {
        try {
            Gift::storeGift($request->validated());

            return redirect()->back()->with('success', 'Gift has been successfully created.');
        } catch (\Throwable $exception) {
            return redirect()->back()->with('error', 'Gift creation failed.')->withInput();
        }
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Gift $gift
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, Gift $gift): JsonResponse
    {
        try {
            if ($request->ajax()) {
                $gift->delete();

                return response()->json($this->formatResponse('success', 'Gift has been successfully deleted.'));
            }
        } catch (\Throwable $exception) {
            return response()->json($this->formatResponse('error', 'Gift deletion failed.'), 400);
        }
    }
}
