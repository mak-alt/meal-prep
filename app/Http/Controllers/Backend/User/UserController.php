<?php

namespace App\Http\Controllers\Backend\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\Backend\Users\StoreUserRequest;
use App\Http\Requests\Backend\Users\UpdateUserRequest;
use App\Models\PaymentProfile;
use App\Models\Profile;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function index(): View
    {
        $users = User::select(['id', 'name', 'email', 'role'])->latest()->paginate(15);

        return \view('backend.users.index', compact('users'));
    }

    /**
     * @return \Illuminate\Contracts\View\View
     */
    public function create(): View
    {
        return \view('backend.users.create');
    }

    /**
     * @param \App\Http\Requests\Backend\Users\StoreUserRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(StoreUserRequest $request): RedirectResponse
    {
        try {
            $user = User::storeUser($request->validated());

            if ($user->isCustomer() && $request->has('update_profile')) {
                Profile::updateOrCreatePersonalDetails($request->validated(), $user, false);
                Profile::updateOrCreateDeliveryAddress($request->validated(), $user);
                Profile::updateOrCreateBillingAddress($request->validated(), $user);
            }

            return redirect()->back()->with('success', 'User has been successfully created.');
        } catch (\Throwable $exception) {
            return redirect()->back()->with('error', 'User creation failed.')->withInput();
        }
    }

    /**
     * @param \App\Models\User $user
     * @return \Illuminate\Contracts\View\View
     */
    public function edit(User $user): View
    {
        $user->load(['profile', 'paymentProfiles']);
        $isCustomer = $user->isCustomer();

        return \view('backend.users.edit', compact('user', 'isCustomer'));
    }

    /**
     * @param \App\Http\Requests\Backend\Users\UpdateUserRequest $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateUserRequest $request, User $user): RedirectResponse
    {
        try {
            $user->updateUser($request->validated());

            if ($request->role === User::ROLES['user'] && $request->has('update_profile')) {
                Profile::updateOrCreatePersonalDetails($request->validated(), $user, false);
                Profile::updateOrCreateDeliveryAddress($request->validated(), $user);
                Profile::updateOrCreateBillingAddress($request->validated(), $user);
            }

            return redirect()->back()->with('success', 'User has benn successfully updated.');
        } catch (\Throwable $exception) {
            return redirect()->back()->with('error', 'User update failed.')->withInput();
        }
    }

    /**
     * @param \App\Models\User $user
     * @param string $status
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateStatus(User $user, string $status): JsonResponse
    {
        try {
            $user->update(['status' => $status]);

            return response()->json($this->formatResponse('success', 'User status has been successfully updated.'));
        } catch (\Throwable $exception) {
            return response()->json($this->formatResponse('error', 'User status update failed.'), 400);
        }
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(Request $request, User $user): JsonResponse
    {
        try {
            if ($request->ajax()) {
                $user->delete();

                return response()->json($this->formatResponse('success', 'User has been successfully deleted.'));
            }
        } catch (\Throwable $exception) {
            return response()->json($this->formatResponse('error', 'User deletion failed.'), 400);
        }
    }

    /**
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\PaymentProfile $paymentProfile
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroyPaymentMethod(Request $request, PaymentProfile $paymentProfile): JsonResponse
    {
        try {
            if ($request->ajax()) {
                $paymentProfile->delete();

                return response()->json($this->formatResponse('success', 'Payment method has been successfully deleted.'));
            }
        } catch (\Throwable $exception) {
            return response()->json($this->formatResponse('error', 'Payment method deletion failed.'), 400);
        }
    }

    public function  userPoints(Request $request)
    {
        $users = User::where('role', User::ROLES['user']);

        if ($request->has('search')){
            $users->where('first_name','like', '%'.$request->search.'%')
                ->orWhere('last_name','like', '%'.$request->search.'%')
                ->orWhere('name','like', '%'.$request->search.'%');
        }
        $users = $users->latest()->paginate(15);

        return \view('backend.users.points')->with([
            'users' => $users,
        ]);
    }
}
