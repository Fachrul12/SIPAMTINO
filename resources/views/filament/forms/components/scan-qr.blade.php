<div>
    <div class="mb-4">
        <button 
            id="startCameraBtn" 
            type="button"
            class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700 transition duration-200 ease-in-out"
            onclick="startCamera()"
        >
            📷 Aktifkan Kamera
        </button>
        <button 
            id="stopCameraBtn" 
            type="button"
            class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700 transition duration-200 ease-in-out ml-2"
            onclick="stopCamera()"
            style="display: none;"
        >
            ⏹️ Hentikan Kamera
        </button>
    </div>
    <div id="reader" style="width: 300px; border: 2px dashed #ccc; border-radius: 8px; padding: 20px; text-align: center; background-color: #f9f9f9;">
        <p style="color: #666; margin: 0;">Klik "Aktifkan Kamera" untuk memulai scan QR code</p>
    </div>
    <script src="https://unpkg.com/html5-qrcode"></script>
    <script>
        let html5QrCode = null;
        let isScanning = false;

        function startCamera() {
            console.log("Starting camera...");
            
            const readerElement = document.getElementById("reader");
            if (!readerElement) {
                console.error("Reader element not found");
                alert("Error: Reader element tidak ditemukan");
                return;
            }

            if (isScanning) {
                alert("Kamera sudah aktif!");
                return;
            }

            // Reset reader content
            readerElement.innerHTML = "<p style='color: #666; margin: 0;'>Memulai kamera...</p>";
            
            // Update button states
            document.getElementById("startCameraBtn").style.display = "none";
            document.getElementById("stopCameraBtn").style.display = "inline-block";

            try {
                html5QrCode = new Html5Qrcode("reader");
                const config = { 
                    fps: 10, 
                    qrbox: { width: 250, height: 250 },
                    aspectRatio: 1.0
                };

                // Check for camera permissions first
                Html5Qrcode.getCameras().then(devices => {
                    console.log("Available cameras:", devices);
                    
                    if (devices && devices.length > 0) {
                        // Use the back camera if available, otherwise use the first camera
                        const cameraId = devices.find(device => 
                            device.label.toLowerCase().includes('back') || 
                            device.label.toLowerCase().includes('rear')
                        )?.id || devices[0].id;

                        console.log("Using camera:", cameraId);

                        html5QrCode.start(
                            cameraId,
                            config,
                            (decodedText) => {
                                console.log("QR Code decoded:", decodedText);
                                // Kirim hasil QR ke Livewire
                                try {
                                    if (window.Livewire && @this) {
                                        @this.set('data.pelanggan_id', decodedText);
                                        stopCamera();
                                        alert("QR Code berhasil dipindai! ID Pelanggan: " + decodedText);
                                    } else {
                                        console.error("Livewire not available");
                                        alert("QR Code: " + decodedText + " (Livewire tidak tersedia)");
                                    }
                                } catch (error) {
                                    console.error("Error setting pelanggan_id:", error);
                                    alert("QR Code dipindai: " + decodedText + ", tapi ada error: " + error.message);
                                }
                            },
                            (errorMessage) => {
                                // ignore decode errors - ini normal saat scan
                            }
                        ).then(() => {
                            console.log("Camera started successfully");
                            isScanning = true;
                        }).catch((err) => {
                            console.error("Unable to start camera:", err);
                            alert("Error memulai kamera: " + err.message + ". Pastikan browser memiliki izin kamera dan Anda menggunakan HTTPS.");
                            
                            // Reset button states
                            document.getElementById("startCameraBtn").style.display = "inline-block";
                            document.getElementById("stopCameraBtn").style.display = "none";
                            readerElement.innerHTML = '<p style="color: #666; margin: 0;">Klik "Aktifkan Kamera" untuk memulai scan QR code</p>';
                        });
                    } else {
                        alert("Tidak ada kamera yang tersedia");
                        // Reset button states
                        document.getElementById("startCameraBtn").style.display = "inline-block";
                        document.getElementById("stopCameraBtn").style.display = "none";
                        readerElement.innerHTML = '<p style="color: #666; margin: 0;">Klik "Aktifkan Kamera" untuk memulai scan QR code</p>';
                    }
                }).catch(err => {
                    console.error("Error getting cameras:", err);
                    alert("Error mengakses kamera: " + err.message);
                    
                    // Reset button states
                    document.getElementById("startCameraBtn").style.display = "inline-block";
                    document.getElementById("stopCameraBtn").style.display = "none";
                    readerElement.innerHTML = '<p style="color: #666; margin: 0;">Klik "Aktifkan Kamera" untuk memulai scan QR code</p>';
                });
            } catch (error) {
                console.error("Error initializing camera:", error);
                alert("Error inisialisasi: " + error.message);
                
                // Reset button states
                document.getElementById("startCameraBtn").style.display = "inline-block";
                document.getElementById("stopCameraBtn").style.display = "none";
                readerElement.innerHTML = '<p style="color: #666; margin: 0;">Klik "Aktifkan Kamera" untuk memulai scan QR code</p>';
            }
            
        }

        function stopCamera() {
            console.log("Stopping camera...");
            
            if (html5QrCode && isScanning) {
                html5QrCode.stop().then(() => {
                    console.log("Camera stopped successfully");
                    isScanning = false;
                    document.getElementById("startCameraBtn").style.display = "inline-block";
                    document.getElementById("stopCameraBtn").style.display = "none";
                    document.getElementById("reader").innerHTML = '<p style="color: #666; margin: 0;">Klik "Aktifkan Kamera" untuk memulai scan QR code</p>';
                }).catch((err) => {
                    console.error("Unable to stop scanning:", err);
                    alert("Error menghentikan kamera: " + err.message);
                });
            }
        }

        // Cleanup saat halaman ditutup
        window.addEventListener('beforeunload', function() {
            if (html5QrCode && isScanning) {
                html5QrCode.stop();
            }
        });

        // Debug: Check if script is loaded
        console.log("QR Scanner script loaded");
    </script>
</div>
