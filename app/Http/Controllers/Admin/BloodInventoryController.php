<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BloodInventory;
use Illuminate\Http\Request;

class BloodInventoryController extends Controller
{
    public function index()
    {
        $bloodTypes = ['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'];
        
        // Auto-create missing blood types
        foreach ($bloodTypes as $type) {
            BloodInventory::firstOrCreate(
                ['blood_type' => $type],
                ['units' => 0]
            );
        }
        
        $inventory = BloodInventory::orderBy('blood_type')->get();
        return view('admin.inventory.index', compact('inventory'));
    }

    public function update(Request $request, BloodInventory $inventory)
    {
        $request->validate([
            'units' => 'required|integer|min:0'
        ]);

        $inventory->update(['units' => $request->units]);

        return back()->with('success', 'Inventory updated successfully!');
    }
}
