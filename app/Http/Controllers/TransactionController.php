<?php

namespace App\Http\Controllers;

use App\Models\Member;
use App\Models\MembershipTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    public function index() { return view('transactions.index', ['transactions' => MembershipTransaction::with('member')->latest()->paginate(10)]); }
    public function create() { return view('transactions.create', ['members' => Member::where('status', 'active')->orderBy('last_name')->get()]); }
    public function store(Request $r)
    {
        $data = $r->validate(['member_id' => 'required|exists:members,id', 'type' => 'required|in:application,renewal', 'amount' => 'required|numeric|min:0', 'remarks' => 'nullable|string']);
        $transaction = MembershipTransaction::create([...$data, 'reference_number' => 'TXN-' . now()->format('Ymd') . '-' . strtoupper(Str::random(6)), 'status' => 'pending', 'transaction_date' => now()]);
        return redirect()->route('transactions.show', $transaction)->with('success', 'Transaction created.');
    }
    public function show(MembershipTransaction $transaction) { $transaction->load(['member', 'payments']); return view('transactions.show', compact('transaction')); }
    public function edit(MembershipTransaction $transaction) { return view('transactions.edit', ['transaction' => $transaction, 'members' => Member::where('status', 'active')->orderBy('last_name')->get()]); }
    public function update(Request $r, MembershipTransaction $transaction)
    {
        $data = $r->validate(['member_id' => 'required|exists:members,id', 'type' => 'required|in:application,renewal', 'amount' => 'required|numeric|min:0', 'status' => 'required|in:pending,paid,approved,expired,cancelled', 'remarks' => 'nullable|string']);
        if ($data['status'] === 'approved' && $transaction->status !== 'paid') return back()->withErrors(['status' => 'Only paid transactions may be approved.']);
        $transaction->update($data);
        return redirect()->route('transactions.show', $transaction)->with('success', 'Transaction updated.');
    }
    public function destroy(MembershipTransaction $transaction) { $transaction->update(['status' => 'cancelled']); return redirect()->route('transactions.index')->with('success', 'Transaction cancelled.'); }
    public function approve(MembershipTransaction $transaction) { abort_unless($transaction->status === 'paid', 422, 'Only paid transactions may be approved.'); $transaction->update(['status' => 'approved']); return back()->with('success', 'Transaction approved.'); }
    public function receipt(MembershipTransaction $transaction) { $transaction->load(['member', 'payments']); return view('transactions.receipt', compact('transaction')); }
}
