<?php

use Juzaweb\Modules\Notification\Http\Controllers\NotificationSubscribeController;

Route::post('notification/{channel}/subscribe', [NotificationSubscribeController::class, 'subscribe'])
    ->name('notification.subscribe')
    ->middleware(['throttle:5,1']);

Route::get('notification/{channel}/verify', [NotificationSubscribeController::class, 'verify'])
    ->name('notification.verify')
    ->middleware(['signed']);
