<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com
 * @license    GNU V2
 */

namespace Juzaweb\Notification\Http\Controllers\Frontend;

use Juzaweb\CMS\Http\Controllers\FrontendController;
use Juzaweb\Notification\Http\Requests\SubscribeRequest;
use Illuminate\Support\Facades\RateLimiter;
use Juzaweb\Notification\Repositories\SubscribeRepository;

class SubscribeController extends FrontendController
{
    public function __construct(protected SubscribeRepository $subscribeRepository)
    {
    }

    public function store(SubscribeRequest $request)
    {
        $executed = RateLimiter::attempt(
            'send-subscribe',
            3,
            function () use ($request) {
                $this->subscribeRepository->create($request->safe()->only(['email', 'name']));
            }
        );

        if (! $executed) {
            return $this->error(__('Too many messages sent!'));
        }

        return $this->success(__('Subscribed successfully!'));
    }
}
