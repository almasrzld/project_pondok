<?php

namespace App\Http\Controllers\Dashboard;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Http\Controllers\Controller;
use App\Models\Rapot;
use App\Models\SantriDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Semester;

class RapotController extends Controller
{
    public function index(Request $request)
    {
        $rapot = Rapot::with(['santri.user', 'semester'])
            ->when($request->search, function ($query) use ($request) {
                $query->whereHas('santri.user', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%');
                });
            })
            ->when($request->semester_id, function ($query) use ($request) {
                $query->where('semester_id', $request->semester_id);
            })
            ->latest('tanggal_input')
            ->paginate(10)
            ->withQueryString();

        $semester = Semester::orderBy('tahun_ajaran', 'desc')
            ->orderBy('nama')
            ->get();

        return view('pages.dashboard.rapot.index', compact('rapot', 'semester'));
    }

    public function create(Rapot $rapot)
    {
        $semester = Semester::where('is_active', true)->get();
        $santri = SantriDetail::with('user')->get();
        return view('pages.dashboard.rapot.create', compact('santri', 'semester'));
    }

    public function store(Request $request, Rapot $rapot)
    {
        $data = $request->validate([
            'santri_id'       => 'required',
            'semester_id'     => 'required',
            'nilai_akademik'  => 'required|integer|min:0|max:100',
            'nilai_akhlak'    => 'required|integer|min:0|max:100',
            'kehadiran'       => 'required|integer|min:0|max:100',
            'catatan_guru'    => 'nullable|string',
        ], [
            'santri_id.required'       => 'Santri wajib diisi',
            'semester_id.required'     => 'Semester wajib diisi',
            'nilai_akademik.required'  => 'Nilai akademik wajib diisi',
            'nilai_akademik.integer'   => 'Nilai akademik harus berupa angka',
            'nilai_akademik.min'       => 'Nilai akademik tidak boleh kurang dari 0',
            'nilai_akademik.max'       => 'Nilai akademik tidak boleh lebih dari 100',
            'nilai_akhlak.required'    => 'Nilai akhlak wajib diisi',
            'nilai_akhlak.integer'     => 'Nilai akhlak harus berupa angka',
            'nilai_akhlak.min'         => 'Nilai akhlak tidak boleh kurang dari 0',
            'nilai_akhlak.max'         => 'Nilai akhlak tidak boleh lebih dari 100',
            'kehadiran.required'       => 'Kehadiran wajib diisi',
            'kehadiran.integer'        => 'Kehadiran harus berupa angka',
            'kehadiran.min'            => 'Kehadiran tidak boleh kurang dari 0',
            'kehadiran.max'            => 'Kehadiran tidak boleh lebih dari 100',
            'catatan_guru.string'      => 'Catatan guru harus berupa teks',
        ]);

        $exists = Rapot::where('santri_id', $data['santri_id'])
            ->where('semester_id', $data['semester_id'])
            ->exists();

        if ($exists) {
            toastr()->error('Rapot santri untuk semester ini sudah ada');
            return back()->withInput();
        }

        $data['admin_id'] = Auth::id();
        $data['tanggal_input'] = now();

        Rapot::create($data);

        toastr()->success('Rapot berhasil ditambahkan');
        return redirect()->route('dashboard.rapot.index');
    }

    public function edit(Rapot $rapot)
    {
        $semester = Semester::all();
        $santri   = SantriDetail::with('user')->get();

        return view('pages.dashboard.rapot.edit', compact('rapot', 'santri', 'semester'));
    }

    public function update(Request $request, Rapot $rapot)
    {
        $data = $request->validate([
            'semester_id'    => 'required|exists:semester,id',
            'nilai_akademik' => 'required|integer|min:0|max:100',
            'nilai_akhlak'   => 'required|integer|min:0|max:100',
            'kehadiran'      => 'required|integer|min:0|max:100',
            'catatan_guru'   => 'nullable|string',
        ], [
            'semester_id.required'    => 'Semester wajib diisi',
            'semester_id.exists'      => 'Semester tidak ditemukan',
            'nilai_akademik.required' => 'Nilai akademik wajib diisi',
            'nilai_akademik.integer'  => 'Nilai akademik harus berupa angka',
            'nilai_akademik.min'      => 'Nilai akademik tidak boleh kurang dari 0',
            'nilai_akademik.max'      => 'Nilai akademik tidak boleh lebih dari 100',
            'nilai_akhlak.required'   => 'Nilai akhlak wajib diisi',
            'nilai_akhlak.integer'    => 'Nilai akhlak harus berupa angka',
            'nilai_akhlak.min'        => 'Nilai akhlak tidak boleh kurang dari 0',
            'nilai_akhlak.max'        => 'Nilai akhlak tidak boleh lebih dari 100',
            'kehadiran.required'      => 'Kehadiran wajib diisi',
            'kehadiran.integer'       => 'Kehadiran harus berupa angka',
            'kehadiran.min'           => 'Kehadiran tidak boleh kurang dari 0',
            'kehadiran.max'           => 'Kehadiran tidak boleh lebih dari 100',
        ]);

        $exists = Rapot::where('santri_id', $rapot->santri_id)
            ->where('semester_id', $request->semester_id)
            ->where('id', '!=', $rapot->id)
            ->exists();

        if ($exists) {
            toastr()->error('Rapot santri untuk semester ini sudah ada');
            return back()->withInput();
        }

        $rapot->update($data);

        toastr()->success('Rapot berhasil diperbarui');
        return redirect()->route('dashboard.rapot.index');
    }

    public function destroy(Rapot $rapot)
    {
        if ($rapot->semester->is_active) {
            toastr()->error('Rapot semester aktif tidak bisa dihapus');
            return back();
        }

        $rapot->delete();
        toastr()->success('Rapot berhasil dihapus');
        return back();
    }

    public function print(Request $request)
    {
        $rapot = Rapot::with(['santri.user', 'semester'])
            ->when($request->semester_id, function ($q) use ($request) {
                $q->where('semester_id', $request->semester_id);
            })
            ->get();

        $semester = Semester::find($request->semester_id);

        $html = view('pages.dashboard.rapot.print', compact('rapot', 'semester'))->render();

        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'DejaVu Sans');

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $dompdf->stream('rapot-santri.pdf');
    }
}
