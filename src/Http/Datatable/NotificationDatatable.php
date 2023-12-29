<?php

namespace Juzaweb\Notification\Http\Datatable;

use Illuminate\Contracts\Database\Query\Builder as QueryBuilder;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Arr;
use Juzaweb\CMS\Abstracts\DataTable;
use Juzaweb\Backend\Models\ManualNotification;
use Juzaweb\CMS\Support\SendNotification;
use Juzaweb\CMS\Jobs\SendNotification as SendNotificationJob;

class NotificationDatatable extends DataTable
{
    public function columns(): array
    {
        return [
            'subject' => [
                'label' => trans('cms::app.subject'),
                'formatter' => [$this, 'rowActionsFormatter'],
            ],
            'method' => [
                'label' => trans('cms::app.via'),
                'width' => '15%',
                'formatter' => function ($value, $row, $index) {
                    if ($row->method) {
                        return $row->method;
                    }

                    return trans('cms::app.all');
                }
            ],
            'created_at' => [
                'label' => trans('cms::app.created_at'),
                'width' => '15%',
                'align' => 'center',
                'formatter' => function ($value, $row, $index) {
                    return jw_date_format($row->created_at);
                }
            ],
            'status' => [
                'label' => trans('cms::app.status'),
                'width' => '15%',
                'formatter' => function ($value, $row, $index) {
                    $status = match ($value) {
                        0 => 'error',
                        1 => 'sended',
                        2 => 'pending',
                        3 => 'sending',
                        4 => 'unsent',
                        default => '',
                    };

                    return view('cms::components.datatable.status', ['status' => $status]);
                }
            ]
        ];
    }

    public function rowActionsFormatter($value, $row, $index): string
    {
        return view(
            'cms::backend.items.datatable_item',
            [
                'value' => $row->data['subject'],
                'row' => $row,
                'actions' => $this->rowAction($row),
                'editUrl' => $this->currentUrl .'/'. $row->id . '/edit',
            ]
        )
            ->render();
    }

    public function query($data): QueryBuilder
    {
        $query = ManualNotification::select(['method', 'data', 'created_at', 'status', 'id']);
        if ($keyword = Arr::get($data, 'keyword')) {
            $query->where(
                function (Builder $q) use ($keyword) {
                    $q->orWhere('name', 'like', '%'. $keyword .'%');
                    $q->orWhere('subject', 'like', '%'. $keyword .'%');
                }
            );
        }

        if ($status = Arr::get($data, 'status')) {
            $query->where('status', '=', $status);
        }

        return $query;
    }

    public function actions(): array
    {
        return [
            'send' => trans('cms::app.send'),
            'delete' => trans('cms::app.delete'),
        ];
    }

    public function bulkActions($action, $ids): void
    {
        switch ($action) {
            case 'delete':
                ManualNotification::destroy($ids);
                break;
            case 'send':
                ManualNotification::whereIn('id', $ids)->update(['status' => 2]);

                $useMethod = config('juzaweb.notification.method');

                if (in_array($useMethod, ['sync', 'queue'])) {
                    foreach ($ids as $id) {
                        $notification = ManualNotification::find($id);
                        if (empty($notification)) {
                            continue;
                        }

                        switch ($useMethod) {
                            case 'sync':
                                (new SendNotification($notification))->send();
                                break;
                            case 'queue':
                                SendNotificationJob::dispatch(
                                    $notification
                                );
                                break;
                        }
                    }
                }
                break;
        }
    }
}
