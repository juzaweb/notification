<?php

use Juzaweb\Notification\Http\Controllers\Backend\NotificationController;
use Juzaweb\Notification\Http\Controllers\Backend\SubscribeController;

Route::jwResource('notification', NotificationController::class);
Route::jwResource('subscribes', SubscribeController::class);
