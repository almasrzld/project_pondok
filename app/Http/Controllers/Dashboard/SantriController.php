<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\SantriDetail;

class SantriController extends Controller
{
    public function index(Request $request)
    {
        $santri = SantriDetail::with('user')
            ->when($request->search, function ($query) use ($request) {
                $query->whereHas('user', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
                })
                ->orWhere('nisn', 'like', '%' . $request->search . '%');
            })
            ->when($request->status, function ($query) use ($request) {
                $query->where('status_pendaftaran', $request->status);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('pages.dashboard.santri.index', compact('santri'));
    }

    public function verify($id)
    {
        $santri = SantriDetail::findOrFail($id);

        $santri->update([
            'status_pendaftaran' => 'verified',
        ]);

        toastr()->success('Pendaftaran santri diverifikasi');

        return back();
    }

    public function reject($id)
    {
        $santri = SantriDetail::findOrFail($id);

        $santri->update([
            'status_pendaftaran' => 'rejected',
        ]);

        toastr()->error('Pendaftaran santri ditolak');

        return back();
    }

}
