<?php

use Juzaweb\Notification\Http\Controllers\SubscribeController;
use Juzaweb\Notification\Http\Controllers\NotificationController;

Route::jwResource('notification', NotificationController::class);
Route::jwResource('subscribes', SubscribeController::class);
