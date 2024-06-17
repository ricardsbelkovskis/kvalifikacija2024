<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Class VerificationController
 *
 * @package App\Http\Controllers
 */
class VerificationController extends Controller
{
    /**
     * Display the verification required view.
     *
     * @return View
     */
    public function verificationRequired(): View
    {
        return view('verification.required'); 
    }
}
