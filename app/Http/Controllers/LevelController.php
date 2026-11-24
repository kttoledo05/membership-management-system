<?php

namespace App\Http\Controllers;

use App\Models\MembershipLevel;
use Illuminate\Http\Request;

class LevelController extends Controller
{
    public function index() { return view('levels.index', ['levels' => MembershipLevel::latest()->get()]); }
    public function create() { return view('levels.create'); }
    public function store(Request $r) { $data = $r->validate(['name' => 'required|unique:membership_levels,name', 'fee' => 'required|numeric|min:0', 'validity_months' => 'required|integer|min:1', 'benefits' => 'nullable|string']); MembershipLevel::create([...$data, 'is_active' => true]); return back()->with('success', 'Level created.'); }
    public function edit(MembershipLevel $level) { return view('levels.edit', compact('level')); }
    public function update(Request $r, MembershipLevel $level) { $data = $r->validate(['name' => 'required|unique:membership_levels,name,' . $level->id, 'fee' => 'required|numeric|min:0', 'validity_months' => 'required|integer|min:1', 'benefits' => 'nullable|string']); $level->update($data); return back()->with('success', 'Level updated.'); }
    public function destroy(MembershipLevel $level) { $level->update(['is_active' => false]); return back()->with('success', 'Level deactivated.'); }
}
