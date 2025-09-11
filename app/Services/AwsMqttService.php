<?php

namespace App\Services;

use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;
use App\Models\Turbidity;
use Illuminate\Support\Facades\Log;

class AwsMqttService
{
    public function listen()
    {
        $server = env('AWS_IOT_HOST');          // Endpoint AWS IoT
        $port = env('AWS_IOT_PORT', 8883);      // Port TLS MQTT
        $clientId = 'laravel-listener-' . uniqid(); // Client ID unik

        // ====== KONFIGURASI KONEKSI ======
        $connectionSettings = (new ConnectionSettings())
            ->setUsername(null) // AWS IoT tidak pakai username/password
            ->setPassword(null)
            ->setKeepAliveInterval(60)
            ->setTlsCertificateAuthorityFile(storage_path('app/' . env('AWS_IOT_CA_PATH')))
            ->setTlsClientCertificateFile(storage_path('app/' . env('AWS_IOT_CERTIFICATE_PATH')))
            ->setTlsClientCertificateKeyFile(storage_path('app/' . env('AWS_IOT_PRIVATE_KEY_PATH')))
            ->setTlsSelfSignedAllowed(true); // penting jika sertifikat self-signed

        // ====== INISIALISASI CLIENT ======
        $mqtt = new MqttClient($server, $port, $clientId);

        $mqtt->connect($connectionSettings, true);

        // Subscribe ke topik
        $mqtt->subscribe(env('AWS_IOT_TOPIC'), function (string $topic, string $message) {
            Log::info("Data received from IoT: {$message}");

            $data = json_decode($message, true);

            if (isset($data['turbidity']) && isset($data['timestamp'])) {
                Turbidity::create([
                    'turbidity'   => $data['turbidity'],
                    'recorded_at' => $data['timestamp'],
                ]);
            }
        }, 0);

        Log::info('Listening for M QTT messages...');
        $mqtt->loop(true); // Listener jalan terus
    }
}
