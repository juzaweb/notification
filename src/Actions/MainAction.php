<?php

namespace Juzaweb\Notification\Actions;

use Juzaweb\Abstracts\Action;
use Juzaweb\Facades\HookAction;

class MainAction extends Action
{
    /**
     * Execute the actions.
     *
     * @return void
     */
    public function handle()
    {
        $this->addAction(Action::BACKEND_CALL_ACTION, [$this, 'addAdminMenus']);
        $this->addAction(Action::BACKEND_CALL_ACTION, [$this, 'addSettingPage']);
    }

    public function addAdminMenus()
    {
        HookAction::addAdminMenu(
            trans('juzaweb::app.notifications'),
            'notification',
            [
                'icon' => 'fa fa-bell',
                'position' => 100
            ]
        );
    }

    public function addSettingPage()
    {
        HookAction::addSettingForm('notification', [
            'name' => trans('juzaweb::app.notification'),
            'view' => view('juno::setting.form'),
        ]);
    }
}
