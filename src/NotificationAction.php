<?php

namespace Juzaweb\Notification;

use Juzaweb\CMS\Abstracts\Action;
use Juzaweb\Notification\Http\Controllers\Frontend\SubscribeController;

class NotificationAction extends Action
{
    public function handle(): void
    {
        $this->addAction(Action::BACKEND_INIT, [$this, 'addAdminMenus']);
        $this->addAction(Action::FRONTEND_INIT, [$this, 'addFrontendAjaxs']);
    }

    public function addAdminMenus(): void
    {
        $this->addAdminMenu(
            trans('cms::app.notifications'),
            'notification',
            [
                'icon' => 'fa fa-bell',
                'position' => 100,
            ]
        );

        $this->registerAdminPage(
            'notification',
            [
                'title' => trans('cms::app.notifications'),
                'menu' => [
                    'icon' => 'fa fa-bell',
                    'parent' => 'notification',
                ]
            ]
        );

        $this->hookAction->registerAdminPage(
            'subscribes',
            [
                'title' => __('Subscribes'),
                'menu' => [
                    'parent' => 'notification',
                    'icon' => 'fa fa-users',
                ]
            ]
        );
    }

    public function addFrontendAjaxs(): void
    {
        $this->registerFrontendAjax(
            'subscribes',
            [
                'method' => 'POST',
                'callback' => [SubscribeController::class, 'store'],
            ]
        );
    }
}
