<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Newsletter\SubscribeRequest;
use App\Models\NewsletterSubscriber;
use Illuminate\Http\JsonResponse;
use Newsletter;

class NewsletterController extends Controller
{
    /**
     * @param \App\Http\Requests\Frontend\Newsletter\SubscribeRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function subscribe(SubscribeRequest $request): JsonResponse
    {
        if ($request->ajax()) {
            try {
                if ( ! Newsletter::isSubscribed($request->email) ) {
                    Newsletter::subscribe($request->email);
                    NewsletterSubscriber::storeSubscriber($request->validated());
                }

                return response()->json($this->formatResponse('success', 'You have successfully subscribed to our updates.'));
            } catch (\Throwable $exception) {
                return response()->json($this->formatResponse('error', 'Subscribing to our updates failed.'), 400);
            }
        }
    }
}
