<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

/**
 * Class EmployeeController
 *
 * @package App\Http\Controllers
 */
class EmployeeController extends Controller
{
    /**
     * Display a listing of the employees.
     *
     * @return View
     */
    public function indexEmployee(): View
    {
        $employees = User::where('role', 'employee')->paginate(10);
        return view('employees.index', compact('employees'));
    }

    /**
     * Show the form for creating a new employee.
     *
     * @return View
     */
    public function createEmployee(): View
    {
        return view('employees.create');
    }

    /**
     * Store a newly created employee in storage.
     *
     * @param Request $request
     * @return RedirectResponse
     */
    public function storeEmployee(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $companyOwner = Auth::user();

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'employee',
            'company_name' => $companyOwner->company_name,
            'account_status' => 1,
        ]);

        return redirect()->route('employees.index')->with('success', 'Employee added successfully.');
    }

    /**
     * Remove the specified employee from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function deleteEmployee(int $id): RedirectResponse
    {
        $employee = User::findOrFail($id);

        if ($employee->role !== 'employee') {
            return redirect()->route('employees.index')->with('error', 'You can only delete employees.');
        }

        $employee->delete();

        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }
}
