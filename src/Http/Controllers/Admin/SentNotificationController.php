<?php

namespace Juzaweb\Modules\Notification\Http\Controllers\Admin;

use Illuminate\Support\Facades\DB;
use Juzaweb\Modules\Core\Facades\Breadcrumb;
use Juzaweb\Modules\Core\Http\Controllers\AdminController;
use Juzaweb\Modules\Notification\Contracts\Notification;
use Juzaweb\Modules\Notification\Http\DataTables\SentNotificationsDataTable;
use Juzaweb\Modules\Notification\Http\Requests\SentNotificationActionsRequest;
use Juzaweb\Modules\Notification\Http\Requests\SentNotificationRequest;
use Juzaweb\Modules\Notification\Jobs\SendNotificationJob;
use Juzaweb\Modules\Notification\Models\ChannelConfig;
use Juzaweb\Modules\Notification\Models\SentNotification;

class SentNotificationController extends AdminController
{
    public function __construct(protected Notification $notificationManager)
    {
    }

    public function index(SentNotificationsDataTable $dataTable)
    {
        Breadcrumb::add(__('Sent Notifications'));

        $createUrl = action([static::class, 'create']);

        return $dataTable->render(
            'notification::sent-notification.index',
            compact('createUrl')
        );
    }

    public function create()
    {
        Breadcrumb::add(__('Sent Notifications'), admin_url('sent-notifications'));

        Breadcrumb::add(__('Create Sent Notification'));

        $backUrl = action([static::class, 'index']);
        $recipientTypes = $this->getRecipientTypesForSelect();
        $channels = $this->getChannelsForCheckbox();

        return view(
            'notification::sent-notification.form',
            [
                'model' => new SentNotification(),
                'action' => action([static::class, 'store']),
                'backUrl' => $backUrl,
                'recipientTypes' => $recipientTypes,
                'channels' => $channels,
            ]
        );
    }

    public function edit(string $id)
    {
        Breadcrumb::add(__('Sent Notifications'), admin_url('sent-notifications'));

        Breadcrumb::add(__('Create Sent Notifications'));

        $model = SentNotification::findOrFail($id);
        $backUrl = action([static::class, 'index']);
        $recipientTypes = $this->getRecipientTypesForSelect();
        $channels = $this->getChannelsForCheckbox();

        return view(
            'notification::sent-notification.form',
            [
                'action' => action([static::class, 'update'], [$id]),
                'model' => $model,
                'backUrl' => $backUrl,
                'recipientTypes' => $recipientTypes,
                'channels' => $channels,
            ]
        );
    }

    public function store(SentNotificationRequest $request)
    {
        $model = DB::transaction(
            function () use ($request) {
                $data = $request->validated();

                return SentNotification::create($data);
            }
        );

        return $this->success([
            'redirect' => action([static::class, 'index']),
            'message' => __('SentNotification :name created successfully', ['name' => $model->name]),
        ]);
    }

    public function update(SentNotificationRequest $request, string $id)
    {
        $model = SentNotification::findOrFail($id);

        $model = DB::transaction(
            function () use ($request, $model) {
                $data = $request->validated();
                $data['sent_at'] = null;

                $model->update($data);

                return $model;
            }
        );

        return $this->success([
            'redirect' => action([static::class, 'index']),
            'message' => __('SentNotification :name updated successfully', ['name' => $model->name]),
        ]);
    }

    public function bulk(SentNotificationActionsRequest $request)
    {
        $action = $request->input('action');
        $ids = $request->input('ids', []);

        $models = SentNotification::whereIn('id', $ids)->get();
        $message = __('Bulk action performed successfully');

        foreach ($models as $model) {
            if ($action === 'delete') {
                $model->delete();
            }

            if ($action === 'sent') {
                SendNotificationJob::dispatch($model);
                $message = __('Notifications have been queued for sending');
            }
        }

        return $this->success([
            'message' => $message,
        ]);
    }

    /**
     * Get recipient types formatted for select dropdown.
     *
     * @return array<string, string>
     */
    protected function getRecipientTypesForSelect(): array
    {
        $types = $this->notificationManager->getRecipientTypesArray();
        $options = [];

        foreach ($types as $key => $type) {
            $options[$key] = $type['label'];
        }

        return $options;
    }

    /**
     * Get notification channels formatted for checkbox group.
     *
     * @return array<string, string>
     */
    protected function getChannelsForCheckbox(): array
    {
        $channels = $this->notificationManager->getChannelsArray();
        $configs = ChannelConfig::whereIn('channel_key', array_keys($channels))
            ->pluck('channel_key')
            ->toArray();
        $options = [];

        foreach ($channels as $key => $channel) {
            if ($channel['config'] && !in_array($key, $configs)) {
                continue;
            }

            $options[$key] = $channel['label'];
        }

        return $options;
    }
}
