<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * Class AdminVerificationController
 *
 * @package App\Http\Controllers
 */
class AdminVerificationController extends Controller
{
    /**
     * Show the verification status.
     *
     * @return View
     */
    public function UserShow(): View
    {
        $users = User::where('account_status', 0)
                     ->select('name', 'company_name', 'created_at', 'id')
                     ->get();

        return view('verification', ['users' => $users]);
    }

    /**
     * Approve the user application.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function UserApprove(int $id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $user->account_status = 1;
        $user->role = 'company_owner';
        $user->save();

        return redirect()->route('verification')->with('success', 'User approved successfully.');
    }

    /**
     * Deny the user application and remove the user.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function UserDeny(int $id): RedirectResponse
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->route('verification')->with('success', 'User denied and removed successfully.');
    }
}
