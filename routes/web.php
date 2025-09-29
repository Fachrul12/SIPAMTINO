<?php

use Illuminate\Support\Facades\Route;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\User;
use App\Models\Turbidity;
use App\Filament\Pages\AdminDashboard;
use App\Filament\Pages\PetugasDashboard;
use App\Filament\Pages\PelangganDashboard;
use App\Http\Controllers\PendaftaranController;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\DB;


Route::get('/', function () {
    $latest = Turbidity::latest('recorded_at')->first();
    return view('landing', compact('latest'));
})->name('landing');

Route::get('/api/turbidity/latest', function () {
    $latest = Redis::get('turbidity:latest');

    return response()->json([
        'turbidity' => $latest ? floatval($latest) : null,
        'time' => now()->toDateTimeString(),
    ]);
});

Route::get('/api/turbidity/summaries', function () {
    $summaries = DB::table('turbidity_summaries')
        ->orderBy('period', 'desc')
        ->limit(24) // ambil 24 jam terakhir
        ->get();

    return response()->json($summaries);
});



Route::get('w', function () {
    return view('welcome');
});


Route::get('/qr-download/{id}', function ($id) {
    $user = User::findOrFail($id);

    // Pastikan hanya pelanggan
    if ($user->role_id !== 3) {
        abort(403, 'QR hanya untuk pelanggan.');
    }

    $encodedId = base64_encode($user->id);

    $qrCode = QrCode::format('png')->size(300)->generate($encodedId);

    return response($qrCode)
        ->header('Content-Type', 'image/png')
        ->header('Content-Disposition', 'attachment; filename="qr-' . $user->name . '.png"');
})->name('qr.download');

// Dashboard Routes
Route::get('/dashboard', AdminDashboard::class)->name('admin.dashboard');
Route::get('/petugas/dashboard', PetugasDashboard::class)->name('petugas.dashboard');
Route::get('/pelanggan/dashboard', PelangganDashboard::class)->name('pelanggan.dashboard');

// Demo Progress Meter
Route::get('/demo/progress-meter', function () {
    return view('progress-meter-demo');
})->name('demo.progress-meter');

// Route pendaftaran pelanggan
Route::get('/pendaftaran', [PendaftaranController::class, 'index'])->name('pendaftaran.form');
Route::post('/pendaftaran', [PendaftaranController::class, 'store'])->name('pendaftaran.store');
Route::get('/pendaftaran/sukses', [PendaftaranController::class, 'sukses'])->name('pendaftaran.sukses');



