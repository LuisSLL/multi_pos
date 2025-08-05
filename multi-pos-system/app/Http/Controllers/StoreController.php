<?php

namespace App\Http\Controllers;

use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class StoreController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function setup()
    {
        $user = Auth::user();
        
        // If user already has a store, redirect to dashboard
        if ($user->store_id) {
            return redirect()->route('dashboard');
        }

        return view('store.setup');
    }

    public function storeSetup(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'description' => 'nullable|string|max:1000',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $logoPath = null;
        if ($request->hasFile('logo')) {
            $logoPath = $request->file('logo')->store('logos', 'public');
        }

        $store = Store::create([
            'name' => $request->name,
            'logo' => $logoPath,
            'address' => $request->address,
            'phone' => $request->phone,
            'email' => $request->email,
            'description' => $request->description,
            'is_active' => true,
            'payment_status' => 'active',
            'payment_due_date' => now()->addMonth()
        ]);

        // Update user with store_id
        Auth::user()->update(['store_id' => $store->id]);

        return redirect()->route('dashboard')->with('success', 'Store setup completed successfully!');
    }

    public function index()
    {
        // Only super admin can view all stores
        if (!Auth::user()->isSuperAdmin()) {
            abort(403);
        }

        $stores = Store::with('owner')->paginate(15);
        return view('admin.stores.index', compact('stores'));
    }

    public function show(Store $store)
    {
        // Check if user can view this store
        if (!Auth::user()->isSuperAdmin() && Auth::user()->store_id !== $store->id) {
            abort(403);
        }

        return view('store.show', compact('store'));
    }

    public function edit(Store $store)
    {
        // Check if user can edit this store
        if (!Auth::user()->isSuperAdmin() && Auth::user()->store_id !== $store->id) {
            abort(403);
        }

        return view('store.edit', compact('store'));
    }

    public function update(Request $request, Store $store)
    {
        // Check if user can update this store
        if (!Auth::user()->isSuperAdmin() && Auth::user()->store_id !== $store->id) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'description' => 'nullable|string|max:1000',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $data = $request->only(['name', 'address', 'phone', 'email', 'description']);

        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($store->logo) {
                Storage::disk('public')->delete($store->logo);
            }
            $data['logo'] = $request->file('logo')->store('logos', 'public');
        }

        $store->update($data);

        return redirect()->back()->with('success', 'Store updated successfully!');
    }

    public function suspend(Store $store)
    {
        // Only super admin can suspend stores
        if (!Auth::user()->isSuperAdmin()) {
            abort(403);
        }

        $store->update([
            'is_active' => false,
            'payment_status' => 'suspended'
        ]);

        return redirect()->back()->with('success', 'Store suspended successfully!');
    }

    public function activate(Store $store)
    {
        // Only super admin can activate stores
        if (!Auth::user()->isSuperAdmin()) {
            abort(403);
        }

        $store->update([
            'is_active' => true,
            'payment_status' => 'active',
            'payment_due_date' => now()->addMonth()
        ]);

        return redirect()->back()->with('success', 'Store activated successfully!');
    }
}
