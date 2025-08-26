<div>
    <div id="reader" style="width: 300px;"></div>
    <script src="https://unpkg.com/html5-qrcode"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function () {
            if (document.getElementById("reader")) {
                const html5QrCode = new Html5Qrcode("reader");
                const config = { fps: 10, qrbox: 250 };

                html5QrCode.start(
                    { facingMode: "environment" }, 
                    config,
                    (decodedText) => {
                        // Kirim hasil QR ke Livewire
                        window.Livewire.find(
                            @this.__instance.id
                        ).set('data.pelanggan_id', decodedText);

                        html5QrCode.stop();
                        alert("Pelanggan ditemukan: " + decodedText);
                    },
                    (errorMessage) => {
                        // ignore decode errors
                    }
                );
            }
        });
    </script>
</div>
