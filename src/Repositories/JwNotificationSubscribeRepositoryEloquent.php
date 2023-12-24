<?php

namespace Juzaweb\Notification\Repositories;

use Juzaweb\CMS\Repositories\BaseRepositoryEloquent;
use Juzaweb\Notification\Models\JwNotificationSubscribe;

class JwNotificationSubscribeRepositoryEloquent extends BaseRepositoryEloquent implements JwNotificationSubscribeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model(): string
    {
        return JwNotificationSubscribe::class;
    }
}
