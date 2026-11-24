<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMemberRequest;
use App\Models\Member;
use App\Models\MembershipCategory;
use App\Models\MembershipLevel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MemberController extends Controller
{
    public function index(Request $request)
    {
        $members = Member::with(['category', 'level'])
            ->when($request->search, fn ($q, $s) => $q->where(fn ($q) => $q->where('first_name', 'like', "%$s%")
                ->orWhere('last_name', 'like', "%$s%")
                ->orWhere('membership_number', 'like', "%$s%")
                ->orWhereHas('category', fn ($q) => $q->where('name', 'like', "%$s%"))
                ->orWhereHas('level', fn ($q) => $q->where('name', 'like', "%$s%"))))
            ->latest()->paginate(10)->withQueryString();
        return view('members.index', compact('members'));
    }

    public function create()
    {
        return view('members.create', ['categories' => MembershipCategory::where('is_active', true)->get(), 'levels' => MembershipLevel::where('is_active', true)->get()]);
    }

    public function store(StoreMemberRequest $request)
    {
        $member = Member::create([...$request->validated(), 'membership_number' => 'MEM-' . now()->format('Ymd') . '-' . strtoupper(Str::random(5)), 'status' => 'active', 'membership_start' => now()]);
        return redirect()->route('members.show', $member)->with('success', 'Member registered successfully.');
    }

    public function show(Member $member) { return view('members.show', compact('member')); }

    public function edit(Member $member)
    {
        return view('members.edit', ['member' => $member, 'categories' => MembershipCategory::where('is_active', true)->get(), 'levels' => MembershipLevel::where('is_active', true)->get()]);
    }

    public function update(StoreMemberRequest $request, Member $member)
    {
        $member->update($request->validated());
        return redirect()->route('members.show', $member)->with('success', 'Member details updated.');
    }

    public function destroy(Member $member)
    {
        $member->update(['status' => 'inactive']);
        return redirect()->route('members.index')->with('success', 'Member deactivated.');
    }
}
