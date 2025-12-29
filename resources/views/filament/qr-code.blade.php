@php
    use Illuminate\Support\Str;

    $pelanggan = $getRecord(); // ini instance Pelanggan
    $user = $pelanggan->user; // ambil relasi user
    $qrCodeData = $pelanggan->id;
    $qrCode = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')->size(200)->generate($qrCodeData);
@endphp

<div class="flex flex-col items-center gap-2">
    <img src="data:image/png;base64,{{ base64_encode($qrCode) }}" alt="QR Code" class="w-48 h-48">

    <x-filament::button
    tag="a"
    href="data:image/png;base64,{{ base64_encode($qrCode) }}"
    download="qrcode-{{ Str::slug($user->name ?? 'pelanggan') }}.png"
    icon="heroicon-o-arrow-down-tray"
    color="success"
    >
        Unduh QR Code PNG
    </x-filament::button>

</div>
