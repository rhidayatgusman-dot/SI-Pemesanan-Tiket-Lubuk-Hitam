<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Fasilitas;
use App\Models\GaleriFasilitas;
use Illuminate\Http\Request;

/**
 * Admin GaleriFasilitasController - CRUD galeri foto fasilitas
 */
class GaleriFasilitasController extends Controller
{
    public function index(Request $request)
    {
        $query = GaleriFasilitas::with('fasilitas');

        if ($request->filled('fasilitas_id')) {
            $query->where('fasilitas_id', $request->fasilitas_id);
        }

        $galeris = $query->orderBy('created_at', 'desc')->paginate(12);
        $fasilitass = Fasilitas::active()->get();

        return view('admin.galeri_fasilitas.index', compact('galeris', 'fasilitass'));
    }

    public function create()
    {
        $fasilitass = Fasilitas::active()->get();
        return view('admin.galeri_fasilitas.create', compact('fasilitass'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'fasilitas_id' => ['required', 'exists:fasilitas,id'],
            'judul' => ['nullable', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string', 'max:255'],
            'foto' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'status' => ['nullable', 'boolean'],
        ]);

        $file = $request->file('foto');
        $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $path = $file->storeAs('fasilitas', $filename, 'public');

        GaleriFasilitas::create([
            'fasilitas_id' => $validated['fasilitas_id'],
            'judul' => $validated['judul'] ?? null,
            'deskripsi' => $validated['deskripsi'] ?? null,
            'foto' => $path,
            'status' => $request->has('status') ? true : true,
        ]);

        return redirect()->route('admin.galeri-fasilitas.index')
            ->with('success', 'Foto fasilitas berhasil ditambahkan.');
    }

    public function edit($id)
    {
        $galeri = GaleriFasilitas::with('fasilitas')->findOrFail($id);
        $fasilitass = Fasilitas::active()->get();
        return view('admin.galeri_fasilitas.edit', compact('galeri', 'fasilitass'));
    }

    public function update(Request $request, $id)
    {
        $galeri = GaleriFasilitas::findOrFail($id);

        $validated = $request->validate([
            'fasilitas_id' => ['required', 'exists:fasilitas,id'],
            'judul' => ['nullable', 'string', 'max:255'],
            'deskripsi' => ['nullable', 'string', 'max:255'],
            'foto' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'status' => ['nullable', 'boolean'],
        ]);

        $data = [
            'fasilitas_id' => $validated['fasilitas_id'],
            'judul' => $validated['judul'] ?? null,
            'deskripsi' => $validated['deskripsi'] ?? null,
            'status' => $request->has('status') ? true : false,
        ];

        if ($request->hasFile('foto')) {
            $galeri->hapusFoto();
            $file = $request->file('foto');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('fasilitas', $filename, 'public');
            $data['foto'] = $path;
        }

        $galeri->update($data);

        return redirect()->route('admin.galeri-fasilitas.index')
            ->with('success', 'Foto fasilitas berhasil diperbarui.');
    }

    public function toggleStatus($id)
    {
        $galeri = GaleriFasilitas::findOrFail($id);
        $galeri->update(['status' => !$galeri->status]);

        return back()->with('success', 'Status foto berhasil diubah.');
    }

    public function destroy($id)
    {
        $galeri = GaleriFasilitas::findOrFail($id);
        $galeri->hapusFoto();
        $galeri->delete();

        return back()->with('success', 'Foto fasilitas berhasil dihapus.');
    }
}
