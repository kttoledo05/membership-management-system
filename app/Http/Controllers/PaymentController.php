<?php

namespace App\Http\Controllers;

use App\Models\MembershipTransaction;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PaymentController extends Controller
{
    public function store(Request $r)
    {
        $data = $r->validate(['membership_transaction_id' => 'required|exists:membership_transactions,id', 'amount_paid' => 'required|numeric|min:0.01', 'payment_method' => 'required|string|max:50', 'payment_date' => 'required|date', 'remarks' => 'nullable|string']);
        $transaction = MembershipTransaction::findOrFail($data['membership_transaction_id']);
        if ((float) $data['amount_paid'] < (float) $transaction->amount) return back()->withErrors(['amount_paid' => 'Payment must cover the transaction amount.']);
        Payment::create([...$data, 'payment_reference' => 'PAY-' . now()->format('Ymd') . '-' . strtoupper(Str::random(6))]);
        $transaction->update(['status' => 'paid']);
        return back()->with('success', 'Payment recorded.');
    }
}
