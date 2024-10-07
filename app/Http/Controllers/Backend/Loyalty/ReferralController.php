<?php

namespace App\Http\Controllers\Backend\Loyalty;

use App\Http\Controllers\Controller;
use App\Models\Referral;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ReferralController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): View
    {
        $referrals = Referral::with('user')->latest()->paginate(15);

        return \view('backend.referrals.index', compact('referrals'));
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Referral $referral
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, Referral $referral): JsonResponse
    {
        try {
            if ($request->ajax()) {
                $referral->delete();

                return response()->json($this->formatResponse('success', 'Referral has been successfully deleted.'));
            }
        } catch (\Throwable $exception) {
            return response()->json($this->formatResponse('error', 'Referral deletion failed.'), 400);
        }
    }
}
