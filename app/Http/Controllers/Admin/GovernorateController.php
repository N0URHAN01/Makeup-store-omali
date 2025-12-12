<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Governorate;
use Illuminate\Http\Request;

class GovernorateController extends Controller
{
    /**
     * Show all governorates
     */
    public function index()
    {
        $governorates = Governorate::latest()->paginate(20);
        return view('admin.governorates.index', compact('governorates'));
    }

    /**
     * Show form to create governorate
     */
    public function create()
    {
        return view('admin.governorates.create');
    }

    /**
     * Store new governorate
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:governorates,name',
            'shipping_cost' => 'required|numeric|min:0'
        ]);

        Governorate::create($request->only(['name', 'shipping_cost']));

        return redirect()->route('admin.governorates.index')
                         ->with('success', 'Governorate created successfully.');
    }

    /**
     * Show form to edit governorate
     */
    public function edit($id)
    {
        $governorate = Governorate::findOrFail($id);
        return view('admin.governorates.edit', compact('governorate'));
    }

    /**
     * Update governorate
     */
    public function update(Request $request, $id)
    {
        $governorate = Governorate::findOrFail($id);

        $request->validate([
            'name' => 'required|unique:governorates,name,' . $governorate->id,
            'shipping_cost' => 'required|numeric|min:0'
        ]);

        $governorate->update($request->only(['name', 'shipping_cost']));

        return redirect()->route('admin.governorates.index')
                         ->with('success', 'Governorate updated successfully.');
    }

    /**
     * Delete a governorate
     */
    public function destroy($id)
    {
        Governorate::findOrFail($id)->delete();

        return redirect()->route('admin.governorates.index')
                         ->with('success', 'Governorate deleted successfully.');
    }
}
