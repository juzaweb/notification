<?php

use Juzaweb\Modules\Notification\Http\Controllers\Admin\SentNotificationController;
use Juzaweb\Modules\Notification\Http\Controllers\ChannelConfigController;

Route::admin('sent-notifications', SentNotificationController::class);
Route::admin('channel-configs', ChannelConfigController::class);
