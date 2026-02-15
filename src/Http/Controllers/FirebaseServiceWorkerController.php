<?php

namespace Juzaweb\Modules\Notification\Http\Controllers;

use Illuminate\Routing\Controller;
use Juzaweb\Modules\Notification\Models\ChannelConfig;

class FirebaseServiceWorkerController extends Controller
{
    public function show()
    {
        // Get FCM config from database
        $fcmConfig = ChannelConfig::where('channel_key', 'fcm')->first();

        abort_if($fcmConfig === null, 404, 'Firebase configuration not found.');

        $firebaseConfig = [];

        if ($fcmConfig && $fcmConfig->config) {
            $config = $fcmConfig->config;
            $firebaseConfig = [
                'apiKey' => $config['apiKey'] ?? '',
                'authDomain' => $config['authDomain'] ?? '',
                'projectId' => $config['projectId'] ?? '',
                'storageBucket' => $config['storageBucket'] ?? '',
                'messagingSenderId' => $config['messagingSenderId'] ?? '',
                'appId' => $config['appId'] ?? '',
            ];

            // Add measurementId if exists
            if (!empty($config['measurementId'])) {
                $firebaseConfig['measurementId'] = $config['measurementId'];
            }
        }

        $configJson = json_encode($firebaseConfig, JSON_THROW_ON_ERROR | JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

        $content = <<<JS
importScripts('https://www.gstatic.com/firebasejs/9.0.0/firebase-app-compat.js');
importScripts('https://www.gstatic.com/firebasejs/9.0.0/firebase-messaging-compat.js');

// Initialize the Firebase app in the service worker
const firebaseConfig = {$configJson};

firebase.initializeApp(firebaseConfig);

// Retrieve an instance of Firebase Messaging
const messaging = firebase.messaging();

// Handle background messages
messaging.onBackgroundMessage((payload) => {
    console.log('[firebase-messaging-sw.js] Received background message ', payload);

    const notificationTitle = payload.notification.title;
    const notificationOptions = {
        body: payload.notification.body,
        icon: payload.notification.icon || '/firebase-logo.png'
    };

    self.registration.showNotification(notificationTitle, notificationOptions);
});
JS;

        return response($content)
            ->header('Content-Type', 'application/javascript')
            ->header('Service-Worker-Allowed', '/');
    }
}
