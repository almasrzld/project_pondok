<?php

namespace App\Http\Controllers\Base;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SantriDetail;
use App\Models\Pendaftaran;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class PendaftaranController extends Controller
{
    public function index()
    {
        return view('pages.base.pendaftaran');
    }

    public function store(Request $request)
    {

        $user = auth()->user();
        $santri = $user->santriDetail;

        $validator = Validator::make($request->all(), [
            'nisn' => 'required|numeric|unique:santri_detail,nisn,' . optional($santri)->id . ',id',
            'tempat_lahir'  => 'required',
            'tanggal_lahir' => 'required|date',
            'jenis_kelamin' => 'required|in:L,P',
            'alamat'        => 'required',
            'no_hp'         => 'required',
            'nama_wali'     => 'required',
            'no_hp_wali'    => 'required',
        ], [
            'nisn.unique' => 'NISN sudah terdaftar',
            'nisn.required' => 'NISN wajib diisi',
            'nisn.numeric' => 'NISN harus berupa angka',
            'tempat_lahir.required' => 'Tempat lahir wajib diisi',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi',
            'tanggal_lahir.date' => 'Format tanggal lahir tidak valid',
            'jenis_kelamin.in' => 'Jenis kelamin tidak valid',
            'jenis_kelamin.required' => 'Jenis kelamin wajib diisi',
            'alamat.required' => 'Alamat wajib diisi',
            'no_hp.required' => 'No HP wajib diisi',
            'nama_wali.required' => 'Nama wali wajib diisi',
            'no_hp_wali.required' => 'No HP wali wajib diisi',
        ]);

        if ($validator->fails()) {
            toastr()->error(
                $validator->errors()->first(),
            );
            return back()->withErrors($validator)->withInput();
        }

        if ($santri) {
            if (in_array($santri->status_pendaftaran, ['pending', 'verified'])) {
                toastr()->error('Pendaftaran sudah dilakukan dan sedang diproses');
                return back();
            }

            if ($santri->status_pendaftaran === 'rejected') {

                $santri->update([
                    'nisn'               => $request->nisn,
                    'tempat_lahir'       => $request->tempat_lahir,
                    'tanggal_lahir'      => $request->tanggal_lahir,
                    'jenis_kelamin'      => $request->jenis_kelamin,
                    'alamat'             => $request->alamat,
                    'no_hp'              => $request->no_hp,
                    'nama_wali'          => $request->nama_wali,
                    'no_hp_wali'         => $request->no_hp_wali,
                    'status_pendaftaran' => 'pending',
                    'tanggal_daftar'     => now(),
                ]);

                toastr()->success('Pendaftaran ulang berhasil, menunggu verifikasi admin');
                return redirect()->route('home');
            }
        }

        SantriDetail::create([
            'user_id'            => $user->id,
            'nisn'               => $request->nisn,
            'tempat_lahir'       => $request->tempat_lahir,
            'tanggal_lahir'      => $request->tanggal_lahir,
            'jenis_kelamin'      => $request->jenis_kelamin,
            'alamat'             => $request->alamat,
            'no_hp'              => $request->no_hp,
            'nama_wali'          => $request->nama_wali,
            'no_hp_wali'         => $request->no_hp_wali,
            'status_pendaftaran' => 'pending',
            'tanggal_daftar'     => now(),
        ]);

        toastr()->success('Pendaftaran berhasil, menunggu verifikasi admin');
        return redirect()->route('home');
    }
}
