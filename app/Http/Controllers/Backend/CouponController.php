<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Coupons\StoreCouponRequest;
use App\Http\Requests\Backend\Coupons\UpdateCouponRequest;
use App\Models\Coupon;
use App\Models\User;
use App\Notifications\Coupons\SentCoupon;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): View
    {
        $coupons = Coupon::latest()->paginate(15);

        return \view('backend.coupons.index', compact('coupons'));
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function create(): View
    {
        $users = User::where('role', User::ROLES['user'])->get();

        return \view('backend.coupons.create', compact('users'));
    }

    /**
     * @param \App\Http\Requests\Backend\Coupons\StoreCouponRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreCouponRequest $request): RedirectResponse
    {
        try {
            $coupon = Coupon::create($request->validated());

            if ($request->has('all_users')) {
                $users = User::get();
            } else {
                $users = $request->has('users') ? User::find($request->users) : [];
            }

            foreach ($users as $user) {
                $user->coupons()->attach($coupon);
               /* $user->notify(new SentCoupon($coupon));*/
            }

            return redirect()->back()->with('success', 'Coupon has been successfully created.');
        } catch (\Throwable $exception) {
            return redirect()->back()->with('error', 'Coupon creation failed.')->withInput();
        }
    }

    /**
     * @param \App\Models\Coupon $coupon
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(Coupon $coupon): View
    {
        $users          = User::where('role', User::ROLES['user'])->get();
        $couponAllUsers = $users->diff($coupon->users()->get())->isEmpty();

        return \view('backend.coupons.edit', compact('coupon', 'users', 'couponAllUsers'));
    }

    /**
     * @param \App\Http\Requests\Backend\Coupons\UpdateCouponRequest $request
     * @param \App\Models\Coupon $coupon
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateCouponRequest $request, Coupon $coupon): RedirectResponse
    {
        try {
            if ($request->has('all_users')) {
                $users = User::get();
            } else {
                $users = $request->has('users') ? User::find($request->users) : collect(new User());
            }

            $coupon->users()->sync($users->pluck('id'));
            $coupon->update($request->validated());

            /*$users->map(function ($user) use ($coupon) {
                $user->notify(new SentCoupon($coupon));
            });*/

            return redirect()->back()->with('success', 'Coupon has been successfully updated.');
        } catch (\Throwable $exception) {
            return redirect()->back()->with('error', 'Coupon update failed.')->withInput();
        }
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Coupon $coupon
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, Coupon $coupon): JsonResponse
    {
        try {
            if ($request->ajax()) {
                /*auth()->user()->coupons()->detach($coupon->id);*/
                $coupon->delete();

                return response()->json($this->formatResponse('success', 'Coupon has been successfully deleted.'));
            }
        } catch (\Throwable $exception) {
            return response()->json($this->formatResponse('error', 'Coupon deletion failed.'), 400);
        }
    }
}
