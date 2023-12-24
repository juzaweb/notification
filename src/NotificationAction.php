<?php

namespace Juzaweb\Notification;

use Juzaweb\CMS\Abstracts\Action;

class NotificationAction extends Action
{
    public function handle(): void
    {
        $this->addAction(Action::BACKEND_INIT, [$this, 'addAdminMenus']);
    }

    public function addAdminMenus(): void
    {
        $this->registerAdminPage(
            'notification',
            [
                'title' => trans('cms::app.notifications'),
                'menu' => [
                    'icon' => 'fa fa-bell',
                    'position' => 100
                ]
            ]
        );
    }
}
