<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use PhpMqtt\Client\MqttClient;
use PhpMqtt\Client\ConnectionSettings;

class MqttController extends Controller
{
    public function kirim(Request $request)
    {
        $server   = $request->input('broker');
        $port     = (int) $request->input('port');
        $clientId = 'laravel-client-' . uniqid();
        $topic    = $request->input('topic');
        $message  = $request->input('message');

        $connectionSettings = new ConnectionSettings();

        try {
            $mqtt = new MqttClient($server, $port, $clientId);
            $mqtt->connect($connectionSettings, true);
            $mqtt->publish($topic, $message, 0); // QoS 0
            $mqtt->disconnect();

            return response()->json(['status' => 'Pesan berhasil dikirim ke broker']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'Gagal mengirim', 'error' => $e->getMessage()], 500);
        }
    }
}
