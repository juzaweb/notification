<?php

namespace Juzaweb\Notification\Repositories;

use Juzaweb\CMS\Repositories\BaseRepositoryEloquent;
use Juzaweb\Notification\Models\EmailSubscribe;

class EmailSubscribeRepositoryEloquent extends BaseRepositoryEloquent implements EmailSubscribeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model(): string
    {
        return EmailSubscribe::class;
    }
}
