<?php

use Illuminate\Support\Facades\Route;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\User;

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

// web.php