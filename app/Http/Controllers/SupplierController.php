<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;

class SupplierController extends Controller
{
    public function index()
    {
        return view('suppliers.index', [
            'suppliers' => Supplier::latest()->get(),
        ]);
    }

    public function create()
    {
        return view('suppliers.create');
    }

    public function store(Request $request)
    {
        Supplier::create($request->validate($this->rules()));

        return redirect()->route('suppliers.index')
            ->with('success', 'Supplier added.');
    }

    public function edit(Supplier $supplier)
    {
        return view('suppliers.edit', ['supplier' => $supplier]);
    }

    public function update(Request $request, Supplier $supplier)
    {
        $supplier->update($request->validate($this->rules()));

        return redirect()->route('suppliers.index')
            ->with('success', 'Supplier updated.');
    }

    public function destroy(Supplier $supplier)
    {
        $supplier->delete();

        return back()->with('success', 'Supplier deleted.');
    }

    // Same rules for create and update, written once
    private function rules(): array
    {
        return [
            'name' => 'required|string|max:150',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:150',
            'address' => 'nullable|string|max:255',
        ];
    }
}
