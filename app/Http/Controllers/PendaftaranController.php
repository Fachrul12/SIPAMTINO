<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CalonPelanggan;
use App\Models\Tarif;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PendaftaranController extends Controller
{
    public function index()
    {
        $tarifs = Tarif::all();
        return view('pendaftaran.form', compact('tarifs'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:calon_pelanggans,email|unique:users,email',
            'no_hp' => 'required|string|max:15',
            'password' => 'required|string|min:8|confirmed',
            'ktp' => 'required|file|mimes:jpeg,jpg,png,pdf|max:2048',
        ], [
            'name.required' => 'Nama wajib diisi',
            'email.required' => 'Email wajib diisi',
            'email.email' => 'Format email tidak valid',
            'email.unique' => 'Email sudah terdaftar',
            'no_hp.required' => 'Nomor HP wajib diisi',
            'password.required' => 'Password wajib diisi',
            'password.min' => 'Password minimal 8 karakter',
            'password.confirmed' => 'Konfirmasi password tidak sama',
            'ktp.required' => 'File KTP wajib diupload',
            'ktp.mimes' => 'File KTP harus berformat jpeg, jpg, png, atau pdf',
            'ktp.max' => 'Ukuran file KTP maksimal 2MB',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        // Upload file KTP
        $ktpPath = null;
        if ($request->hasFile('ktp')) {
            $ktpPath = $request->file('ktp')->store('ktp', 'public');
        }

        // Simpan data calon pelanggan
        CalonPelanggan::create([
            'name' => $request->name,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'password' => $request->password, // akan di-hash otomatis oleh cast
            'tarif_id' => 1, // default tarif_id 1
            'ktp_path' => $ktpPath,
            'status' => 'pending',
        ]);

        return redirect()->route('pendaftaran.sukses')
            ->with('success', 'Pendaftaran berhasil! Silakan tunggu konfirmasi dari admin.');
    }

    public function sukses()
    {
        return view('pendaftaran.sukses');
    }
}
