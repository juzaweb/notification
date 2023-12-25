<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com
 * @license    GNU V2
 */

namespace Juzaweb\Notification\Tests\Feature;

use Juzaweb\Tests\TestCase;

class SubscribeTest extends TestCase
{
    protected $defaultHeaders = [
        'Accept' => 'application/json',
        'X-Requested-With' => 'XMLHttpRequest',
    ];

    public function testSubscribe(): void
    {
        $faker = \Faker\Factory::create();

        $response = $this->post(
            'ajax/subscribes',
            [
                'email' => $faker->email,
            ]
        );

        $response->assertStatus(200);

        $response->assertJson(
            [
                'status' => 'success',
            ]
        );
    }
}
