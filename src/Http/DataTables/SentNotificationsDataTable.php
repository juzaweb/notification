<?php

namespace Juzaweb\Modules\Notification\Http\DataTables;

use Illuminate\Database\Eloquent\Model;
use Juzaweb\Modules\Core\DataTables\Action;
use Juzaweb\Modules\Core\DataTables\BulkAction;
use Juzaweb\Modules\Core\DataTables\Column;
use Juzaweb\Modules\Core\DataTables\DataTable;
use Illuminate\Database\Eloquent\Builder;
use Juzaweb\Modules\Notification\Models\SentNotification;

class SentNotificationsDataTable extends DataTable
{
    protected string $actionUrl = 'sent-notifications/bulk';

    public function query(SentNotification $model): Builder
    {
        return $model->newQuery();
    }

    public function getColumns(): array
    {
        return [
			Column::checkbox(),
			Column::id(),
			Column::actions(),
			Column::editLink('title', admin_url('sent-notifications/{id}/edit'), __('core::translation.label')),
			Column::make('message'),
			Column::make('recipient_type'),
			Column::make('via'),
			Column::make('sent_at'),
			Column::createdAt()
		];
    }

    public function actions(Model $model): array
    {
        return [
            Action::edit(admin_url("sent-notifications/{$model->id}/edit"))
                ->can('sent-notifications.edit'),
            Action::delete()->can('sent-notifications.delete'),
        ];
    }

    public function bulkActions(): array
    {
        return [
            BulkAction::make(__('Sent'), icon: 'fas fa-solid fa-paper-plane')
                ->can('sent-notifications.sent'),
            BulkAction::delete()->can('sent-notifications.delete'),
        ];
    }
}
