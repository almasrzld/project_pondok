<?php

namespace App\Http\Controllers\Base;

use Dompdf\Dompdf;
use Dompdf\Options;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rapot;
use App\Models\Semester;
use App\Models\Pembayaran;

class RapotController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();

        $sppLunas = Pembayaran::whereHas('santri', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->whereHas('jenisPembayaran', function ($q) {
                $q->where('nama', 'SPP Bulanan');
            })
            ->where('status_pembayaran', 'lunas')
            ->exists();

        if (! $sppLunas) {
            return view('pages.base.rapot-locked');
        }

        $rapot = Rapot::with(['semester'])
            ->whereHas('santri', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->when($request->semester_id, function ($q) use ($request) {
                $q->where('semester_id', $request->semester_id);
            })
            ->orderBy('semester_id', 'desc')
            ->get();

        $semester = Semester::all();

        return view('pages.base.rapot', compact('rapot', 'semester'));
    }

    public function print(Request $request)
    {
        $user = auth()->user();

        $sppLunas = Pembayaran::whereHas('santri', fn ($q) =>
                $q->where('user_id', $user->id)
            )
            ->whereHas('jenisPembayaran', fn ($q) =>
                $q->where('nama', 'SPP Bulanan')
            )
            ->where('status_pembayaran', 'lunas')
            ->exists();

        abort_if(! $sppLunas, 403);

        $rapot = Rapot::with(['semester'])
            ->whereHas('santri', fn ($q) =>
                $q->where('user_id', $user->id)
            )
            ->when($request->semester_id, fn ($q) =>
                $q->where('semester_id', $request->semester_id)
            )
            ->get();

        $logo = base64_encode(
            file_get_contents(public_path('images/logo.png'))
        );

        $html = view('pages.base.rapot-print', compact('rapot', 'user', 'logo'))->render();

        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $options->set('defaultFont', 'DejaVu Sans');

        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        return $dompdf->stream('rapot.pdf');
    }
}
