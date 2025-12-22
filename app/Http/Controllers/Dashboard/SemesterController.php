<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Semester;

class SemesterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $semester = Semester::orderBy('tahun_ajaran','desc')->get();
        return view('pages.dashboard.semester.index', compact('semester'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('pages.dashboard.semester.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'nama' => 'required|in:Ganjil,Genap',
            'tahun_ajaran' => 'required',
        ]);

        if ($request->has('is_active')) {
            Semester::where('is_active', true)->update(['is_active' => false]);
            $data['is_active'] = true;
        }

        Semester::create($data);

        toastr()->success('Semester berhasil ditambahkan');

        return redirect()
            ->route('dashboard.semester.index');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        return view('pages.dashboard.semester.edit', compact('semester'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Semester $semester)
    {
        $data = $request->validate([
            'nama' => 'required|in:Ganjil,Genap',
            'tahun_ajaran' => 'required',
        ]);

        if ($request->has('is_active')) {
            Semester::where('is_active', true)->update(['is_active' => false]);
            $data['is_active'] = true;
        } else {
            $data['is_active'] = false;
        }

        $semester->update($data);

        toastr()->success('Semester berhasil diperbarui');

        return redirect()
            ->route('dashboard.semester.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Semester $semester)
    {
        if ($semester->is_active) {
            toastr()->error('Semester aktif tidak bisa dihapus');
            return back();
        }
        
        if ($semester->rapot()->count() > 0) {
            toastr()->error('Semester sedang digunakan');
            return back();
        }

        $semester->delete();

        toastr()->success('Semester berhasil dihapus');

        return back();
    }
}
