<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\MembershipTransaction;
use App\Models\Payment;

class DashboardController extends Controller
{
    public function index()
    {
        return view('dashboard', [
            'totalMembers' => Member::count(),
            'activeMembers' => Member::where('status', 'active')->count(),
            'pendingTransactions' => MembershipTransaction::where('status', 'pending')->count(),
            'collectedPayments' => Payment::sum('amount_paid'),
            'recentTransactions' => MembershipTransaction::with('member')->latest()->limit(6)->get(),
        ]);
    }
}
