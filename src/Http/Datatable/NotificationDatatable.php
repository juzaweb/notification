<?php

namespace Juzaweb\Notification\Http\Datatable;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\Arr;
use Juzaweb\Abstracts\DataTable;
use Juzaweb\Notification\Models\ManualNotification;
use Juzaweb\Notification\SendNotification;
use Juzaweb\Notification\Jobs\SendNotification as SendNotificationJob;

class NotificationDatatable extends DataTable
{
    /**
     * Columns datatable
     *
     * @return array
     */
    public function columns()
    {
        return [
            'subject' => [
                'label' => trans('juzaweb::app.subject'),
                'formatter' => [$this, 'rowActionsFormatter'],
            ],
            'method' => [
                'label' => trans('juzaweb::app.via'),
                'width' => '15%',
                'formatter' => function ($value, $row, $index) {
                    if ($row->method) {
                        return $row->method;
                    }

                    return trans('juzaweb::app.all');
                }
            ],
            'error' => [
                'label' => trans('juzaweb::app.error'),
                'width' => '20%',
            ],
            'created_at' => [
                'label' => trans('juzaweb::app.created_at'),
                'width' => '15%',
                'align' => 'center',
                'formatter' => function ($value, $row, $index) {
                    return jw_date_format($row->created_at);
                }
            ],
            'status' => [
                'label' => trans('juzaweb::app.status'),
                'width' => '15%',
                'formatter' => function ($value, $row, $index) {
                    switch ($value) {
                        case 0: return trans('juzaweb::app.error');
                        case 1: return trans('juzaweb::app.sended');
                        case 2: return trans('juzaweb::app.pending');
                        case 3: return trans('juzaweb::app.sending');
                        case 4: return trans('juzaweb::app.unsent');
                    }
                }
            ]
        ];
    }

    /**
     * Query data datatable
     *
     * @param array $data
     * @return Builder
     */
    public function query($data)
    {
        $query = ManualNotification::query();
        if ($keyword = Arr::get($data, 'keyword')) {
            $query->where(function (Builder $q) use ($keyword) {
                $q->orWhere('name', 'like', '%'. $keyword .'%');
                $q->orWhere('subject', 'like', '%'. $keyword .'%');
            });
        }

        if ($status = Arr::get($data, 'status')) {
            if (!is_null($status)) {
                $query->where('status', '=', $status);
            }
        }

        return $query;
    }

    public function bulkActions($action, $ids)
    {
        switch ($action) {
            case 'delete':
                ManualNotification::destroy($ids);
                break;
            case 'send':
                ManualNotification::whereIn('id', $ids)
                    ->update([
                        'status' => 2
                    ]);

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
                                SendNotificationJob::dispatch($notification);
                                break;
                        }
                    }
                }
                break;
        }
    }
}