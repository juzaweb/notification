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

use Faker\Factory;
use Juzaweb\Tests\TestCase;

class TestSubscribeByEmail extends TestCase
{
    protected $defaultHeaders = [
        'Accept' => 'application/json',
        'X-Requested-With' => 'XMLHttpRequest',
    ];

    public function testSubscribeByEmail(): void
    {
        $faker = Factory::create();

        $this->post(
            'ajax/email-subscribe',
            [
                'email' => $faker->email(),
            ]
        )
            ->assertStatus(200)
            ->assertJson(['status' => true]);
    }
}
