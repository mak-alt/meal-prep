<?php

namespace App\Http\Controllers\Backend\User;

use App\Http\Controllers\Controller;
use App\Models\NewsletterSubscriber;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): View
    {
        $newsletterSubscribers = NewsletterSubscriber::latest()->paginate(15);

        return \view('backend.users.newsletter-subscribers.index', compact('newsletterSubscribers'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\NewsletterSubscriber $newsletterSubscriber
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, NewsletterSubscriber $newsletterSubscriber): JsonResponse
    {
        try {
            if ($request->ajax()) {
                $newsletterSubscriber->delete();

                return response()->json($this->formatResponse('success', 'Newsletter subscriber has been successfully deleted.'));
            }
        } catch (\Throwable $exception) {
            return response()->json($this->formatResponse('error', 'Newsletter subscriber deletion failed.'), 400);
        }
    }
}
