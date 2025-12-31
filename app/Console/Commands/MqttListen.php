<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;
use PhpMqtt\Client\Exceptions\MqttClientException;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Log;

class MqttListen extends Command
{
    protected $signature = 'mqtt:listen';
    protected $description = 'Listen to AWS IoT Core MQTT and push turbidity data to Redis';

    public function handle()
    {
        $host = env('AWS_IOT_ENDPOINT', 'a1uhfqvc4cvok5-ats.iot.us-east-1.amazonaws.com');
        $port = env('AWS_IOT_PORT', 8883);
        $clientId = env('AWS_IOT_CLIENT_ID', 'laravel_listener_2' . uniqid());
        $topic = env('AWS_IOT_TOPIC', 'ESP8266/kekeruhan');

        $this->info("Connecting to AWS IoT MQTT broker at {$host}:{$port} ...");

        try {
            // TLS configuration
            $connectionSettings = (new ConnectionSettings)
                ->setUseTls(true)
                ->setTlsCertificateAuthorityFile(storage_path('app/aws-iot/AmazonRootCA1.pem'))
                ->setTlsClientCertificateFile(storage_path('app/aws-iot/certificate.pem.crt'))
                ->setTlsClientCertificateKeyFile(storage_path('app/aws-iot/private.pem.key'))
                ->setTlsVerifyPeer(true)
                ->setTlsVerifyPeerName(true)
                ->setKeepAliveInterval(60)
                ->setConnectTimeout(30);

            $mqtt = new MqttClient($host, $port, $clientId);

            $mqtt->connect($connectionSettings, true);
            $this->info('✅ Connected to AWS IoT Core successfully.');

            // Subscribe ke topic sensor
            $mqtt->subscribe($topic, function (string $topic, string $message) {
                $this->info("📩 Message received on [{$topic}]: {$message}");

                try {
                    $message = trim($message, "\x00..\x1F"); 

                    $data = json_decode($message, true);

                    if (!isset($data['turbidity'])) {
                        $this->error('⚠️ Invalid message: missing turbidity field.');
                        return;
                    }

                    $turbidity = floatval($data['turbidity']);
                    if (!is_numeric($turbidity)) {
                        $this->error("⚠️ Invalid turbidity value: {$data['turbidity']}");
                        return;
                    }

                    // Push ke Redis buffer (untuk dihitung avg/min/max tiap jam)
                    Redis::rpush('turbidity:buffer', $turbidity);

                    // Simpan nilai terbaru (untuk dashboard realtime)
                    Redis::set('turbidity:latest', $turbidity);

                    $this->info("✅ Turbidity pushed to Redis: {$turbidity}");
                } catch (\Exception $e) {
                    $this->error('❌ Error handling message: ' . $e->getMessage());
                    Log::error('MQTT Save Error', [
                        'exception' => $e,
                        'raw_message' => $message,
                    ]);
                }
            }, 0);

            $this->info("👂 Listening for messages on topic: {$topic}");
            $mqtt->loop(true);

        } catch (MqttClientException $e) {
            $this->error('❌ MQTT Client Exception: ' . $e->getMessage());
            Log::error('MQTT Client Exception', ['exception' => $e]);
        } catch (\Exception $e) {
            $this->error('❌ General Exception: ' . $e->getMessage());
            Log::error('General MQTT Error', ['exception' => $e]);
        }
    }
}
