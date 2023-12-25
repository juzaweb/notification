<?php

namespace Juzaweb\Notification\Repositories;

use Juzaweb\CMS\Repositories\BaseRepositoryEloquent;
use Juzaweb\Notification\Models\Subscribe;

class SubscribeRepositoryEloquent extends BaseRepositoryEloquent implements SubscribeRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model(): string
    {
        return Subscribe::class;
    }
}
