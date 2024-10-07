<?php

namespace App\Http\Controllers\Frontend\Loyalty;

use App\Http\Controllers\Controller;
use App\Http\Requests\Frontend\Loyalty\Referrals\SendReferralInvitationRequest;
use App\Http\Requests\Frontend\Loyalty\Referrals\UpdateCodeRequest;
use App\Models\Referral;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;

class ReferralController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): View
    {
        $user = auth()->user();

        if ($user) {
            $referralCode = $user->referral_code;
            $referrals    = $user->referrals()->with('user')->latest()->get();
        }

        return \view('frontend.referrals.index', [
            'referralCode' => $referralCode ?? null,
            'referrals'    => $referrals ?? [],
        ]);
    }

    /**
     * @param \App\Http\Requests\Frontend\Loyalty\Referrals\UpdateCodeRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateCode(UpdateCodeRequest $request): JsonResponse
    {
        if ($request->ajax()) {
            try {
                auth()->user()->update(['referral_code' => $request->code]);

                return response()->json(
                    $this->formatResponse(
                        'success',
                        'Referral code has been successfully updated.',
                        [
                            'referral_code'     => $request->code,
                            'referral_code_url' => route('frontend.referrals.join', $request->code),
                        ]
                    )
                );
            } catch (\Throwable $exception) {
                return response()->json($this->formatResponse('error', 'Referral code update failed.'), 400);
            }
        }
    }

    /**
     * @param \App\Http\Requests\Frontend\Loyalty\Referrals\SendReferralInvitationRequest $request
     * @param string $deliveryChannel
     * @return \Illuminate\Http\JsonResponse
     */
    public function send(SendReferralInvitationRequest $request, string $deliveryChannel): JsonResponse
    {
        if ($request->ajax()) {
            try {
                DB::transaction(function () use ($request, $deliveryChannel) {
                    Referral::storeReferralAndSendInvitationNotification($request->validated(), $deliveryChannel);
                });

                return response()->json($this->formatResponse('success', 'Referral code has been successfully shared.'));
            } catch (\Throwable $exception) {
                return response()->json($this->formatResponse('error', 'Sharing referral code failed.'), 400);
            }
        }
    }

    /**
     * @param string $referralCode
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse
     */
    public function join(string $referralCode)
    {
        $referralInviter = User::where('referral_code', $referralCode)->firstOrFail();

        if (auth()->check()) {
            if ($referralInviter->id === auth()->id()) {
                return redirect()->route('frontend.referrals.index');
            }

            if (Referral::where('inviter_id', $referralInviter->id)->where('user_id', auth()->id())->exists()) {
                return redirect()->route('frontend.rewards.index')
                    ->with('warning', 'You have already joined referral program.');
            }

            Referral::join($referralInviter);

            setSessionResponseMessage('You have successfully joined referral program.');

            return redirect()->route('frontend.rewards.index');
        }

        $joinMode = true;

        return \view('frontend.referrals.index', compact('joinMode'));
    }
}
