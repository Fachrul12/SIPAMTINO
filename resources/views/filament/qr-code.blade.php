@php
    use Illuminate\Support\Str;

    $user = $getRecord();
    $qrCodeData = $user->id;
    $qrCode = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('png')->size(200)->generate($qrCodeData);
@endphp

<div class="flex flex-col items-center gap-2">
    <img src="data:image/png;base64,{{ base64_encode($qrCode) }}" alt="QR Code" class="w-48 h-48">

    <a 
        href="data:image/png;base64,{{ base64_encode($qrCode) }}" 
        download="qrcode-{{ Str::slug($user->name) }}.png"
        class="px-4 py-2 bg-green-600 text-white text-sm rounded hover:bg-green-700 transition"
    >
        Unduh QR Code PNG
    </a>
</div>
