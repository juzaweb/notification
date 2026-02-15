<?php

namespace Juzaweb\Modules\Notification\Http\DataTables;

use Illuminate\Database\Eloquent\Model;
use Juzaweb\Modules\Core\DataTables\Action;
use Juzaweb\Modules\Core\DataTables\BulkAction;
use Juzaweb\Modules\Core\DataTables\Column;
use Juzaweb\Modules\Core\DataTables\DataTable;
use Illuminate\Database\Eloquent\Builder;
use Juzaweb\Modules\Notification\Models\ChannelConfig;

class ChannelConfigsDataTable extends DataTable
{
    protected string $actionUrl = 'channel-configs/bulk';

    public function query(ChannelConfig $model): Builder
    {
        return $model->newQuery();
    }

    public function getColumns(): array
    {
        return [
			Column::checkbox(),
			Column::id(),
			Column::actions(),
			Column::make('channel_key'),
			Column::make('config'),
			Column::createdAt()
		];
    }

    public function actions(Model $model): array
    {
        return [
            Action::edit(admin_url("channel-configs/{$model->id}/edit"))->can('channel-configs.edit'),
            Action::delete()->can('channel-configs.delete'),
        ];
    }

    public function bulkActions(): array
    {
        return [
            BulkAction::delete()->can('channel-configs.delete'),
        ];
    }
}
