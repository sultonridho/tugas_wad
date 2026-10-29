<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use Illuminate\Http\Request;

class DriverController extends Controller
{
    public function index(Request $request)
    {
        $drivers = Driver::latest()->get();
        $editDriver = null;

        if ($request->filled('edit')) {
            $editDriver = Driver::findOrFail($request->edit);
        }

        return view('index', compact('drivers', 'editDriver'));
    }

    public function create()
    {
        return redirect()->route('drivers.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'umur' => 'required|integer|min:1',
            'pengalaman_pengemudi' => 'required|integer|min:0',
            'nomor_sim_aktif' => 'required|string|max:255',
            'kontak' => 'required|string|max:255',
            'status' => 'required|string|max:255',
        ]);

        Driver::create($validated);

        return redirect()->route('drivers.index')
            ->with('success', 'Data driver berhasil ditambahkan!');
    }

    public function show(Driver $driver)
    {
        return redirect()->route('drivers.index');
    }

    public function edit(Driver $driver)
    {
        return redirect()->route('drivers.index', [
            'edit' => $driver->id,
        ]);
    }

    public function update(Request $request, Driver $driver)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'umur' => 'required|integer|min:1',
            'pengalaman_pengemudi' => 'required|integer|min:0',
            'nomor_sim_aktif' => 'required|string|max:255',
            'kontak' => 'required|string|max:255',
            'status' => 'required|string|max:255',
        ]);

        $driver->update($validated);

        return redirect()->route('drivers.index')
            ->with('success', 'Data driver berhasil diperbarui!');
    }

    public function destroy(Driver $driver)
    {
         $driver->delete();

        return redirect()->route('drivers.index')
            ->with('success', 'Data driver berhasil dihapus!');
    }
}
