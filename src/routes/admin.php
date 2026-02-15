<?php

use Juzaweb\Modules\Notification\Http\Controllers\Admin\SentNotificationController;
use Juzaweb\Modules\Notification\Http\Controllers\ChannelConfigController;

Route::admin('sent-notifications', SentNotificationController::class);
Route::get('/admin/channel-configs/config/{channelKey}', [ChannelConfigController::class, 'getChannelConfig'])
    ->name('admin.channel-configs.config');
Route::admin('channel-configs', ChannelConfigController::class);
