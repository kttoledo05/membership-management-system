<?php

namespace App\Http\Controllers;

use App\Models\MembershipCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index() { return view('categories.index', ['categories' => MembershipCategory::latest()->get()]); }
    public function create() { return view('categories.create'); }
    public function store(Request $r) { $data = $r->validate(['name' => 'required|unique:membership_categories,name', 'description' => 'nullable|string']); MembershipCategory::create([...$data, 'is_active' => true]); return back()->with('success', 'Category created.'); }
    public function edit(MembershipCategory $category) { return view('categories.edit', compact('category')); }
    public function update(Request $r, MembershipCategory $category) { $data = $r->validate(['name' => 'required|unique:membership_categories,name,' . $category->id, 'description' => 'nullable|string']); $category->update($data); return back()->with('success', 'Category updated.'); }
    public function destroy(MembershipCategory $category) { $category->update(['is_active' => false]); return back()->with('success', 'Category deactivated.'); }
}
