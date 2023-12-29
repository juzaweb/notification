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

use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Juzaweb\CMS\Http\Controllers\FrontendController;
use Juzaweb\Notification\Http\Requests\EmailSubscribeRequest;
use Illuminate\Support\Facades\RateLimiter;
use Juzaweb\Notification\Repositories\EmailSubscribeRepository;

class SubscribeController extends FrontendController
{
    public function __construct(protected EmailSubscribeRepository $subscribeRepository)
    {
    }

    public function storeEmail(EmailSubscribeRequest $request): JsonResponse|RedirectResponse
    {
        $executed = RateLimiter::attempt(
            'email-subscribe',
            3,
            function () use ($request) {
                $data = $request->safe()->merge(['active' => true])->toArray();

                $this->subscribeRepository->create($data);
            }
        );

        if (! $executed) {
            return $this->error(__('Too many messages sent!'));
        }

        return $this->success(__('Subscribed successfully!'));
    }
}
