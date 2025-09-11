<?php

use Illuminate\Support\Facades\Route;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\User;
use App\Models\Turbidity;
use App\Filament\Pages\AdminDashboard;
use App\Filament\Pages\PetugasDashboard;
use App\Filament\Pages\PelangganDashboard;
use App\Http\Controllers\TurbidityController;


Route::get('/', function () {
    $latest = Turbidity::latest('recorded_at')->first();
    return view('landing', compact('latest'));
});

// API Route for getting latest turbidity data
Route::get('/api/turbidity/latest', [TurbidityController::class, 'getLatest'])->name('api.turbidity.latest');
Route::get('/api/turbidity/history', [TurbidityController::class, 'getHistory'])->name('api.turbidity.history');

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

// web.php



