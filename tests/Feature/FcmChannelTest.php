<?php

namespace Juzaweb\Modules\Notification\Tests\Feature;

use Juzaweb\Modules\Notification\Tests\TestCase;
use Juzaweb\Modules\Notification\Facades\Notification;

class FcmChannelTest extends TestCase
{
    public function test_fcm_channel_is_registered()
    {
        $this->assertTrue(Notification::hasChannel('fcm'));
    }
}
