<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;
use PhpMqtt\Client\Exceptions\MqttClientException;
use App\Models\Turbidity;
use Illuminate\Support\Facades\Log;

class MqttListen extends Command
{
    /**
     * Nama command yang dipanggil via artisan.
     */
    protected $signature = 'mqtt:listen';

    /**
     * Deskripsi command.
     */
    protected $description = 'Listen to AWS IoT Core MQTT and store turbidity data';

    /**
     * Jalankan command.
     */
    public function handle()
    {
        $host = env('AWS_IOT_ENDPOINT', 'a1b2c3d4e5f6-ats.iot.ap-southeast-1.amazonaws.com');
        $port = env('AWS_IOT_PORT', 8883);
        $clientId = env('AWS_IOT_CLIENT_ID', 'laravel_listener');
        $topic = env('AWS_IOT_TOPIC', 'turbidity/sensor');

        $this->info("Connecting to AWS IoT MQTT broker at {$host}:{$port} ...");

        try {
            // TLS settings
            $connectionSettings = (new ConnectionSettings)
                ->setUsername(null)
                ->setPassword(null)
                ->setUseTls(true)
                ->setTlsCertificateAuthorityFile(storage_path('app/aws-iot/AmazonRootCA1.pem'))
                ->setTlsClientCertificateFile(storage_path('app/aws-iot/certificate.pem.crt'))
                ->setTlsClientCertificateKeyFile(storage_path('app/aws-iot/private.pem.key'))
                ->setTlsVerifyPeer(true)
                ->setTlsVerifyPeerName(true)
                ->setKeepAliveInterval(60)
                ->setConnectTimeout(30);

            // Create MQTT Client
            $mqtt = new MqttClient($host, $port, $clientId);

            // Connect to AWS IoT
            $mqtt->connect($connectionSettings, true);
            $this->info('Connected to AWS IoT Core successfully.');

            // Subscribe to topic
            $mqtt->subscribe($topic, function (string $topic, string $message) {
                $this->info("Message received on topic [{$topic}]: {$message}");

                try {
                    $data = json_decode($message, true);

                    // Pastikan data valid
                    if (!isset($data['turbidity'])) {
                        $this->error('Invalid message format: "turbidity" field missing.');
                        return;
                    }

                    // Simpan ke database
                    Turbidity::create([
                        'turbidity' => $data['turbidity'],
                        'recorded_at' => now(),
                    ]);

                    $this->info("Data saved: Turbidity = {$data['turbidity']}");
                } catch (\Exception $e) {
                    $this->error('Error saving data: ' . $e->getMessage());
                    Log::error('MQTT Save Error', ['exception' => $e]);
                }
            }, 0);

            // Loop forever
            $this->info("Listening for messages on topic: {$topic}");
            $mqtt->loop(true);

        } catch (MqttClientException $e) {
            $this->error('MQTT Client Exception: ' . $e->getMessage());
            Log::error('MQTT Client Exception', ['exception' => $e]);
        } catch (\Exception $e) {
            $this->error('General Exception: ' . $e->getMessage());
            Log::error('General MQTT Error', ['exception' => $e]);
        }
    }
}
