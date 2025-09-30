@if($getState())
    <div class="flex justify-center">
        <img src="{{ Storage::url($getState()) }}" 
             alt="Foto Pengaduan" 
             class="border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); max-width: 100%; height: auto; max-height: 300px;"
             style="border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.15); margin-top: 12px; max-width: 100%; height: auto;">
    </div>
@else
    <p class="text-gray-500">Tidak ada foto lampiran.</p>
@endif