<?php

namespace Juzaweb\Modules\Notification\Http\Controllers;

use Juzaweb\Modules\Core\Facades\Breadcrumb;
use Juzaweb\Modules\Core\Http\Controllers\AdminController;
use Illuminate\Support\Facades\DB;
use Juzaweb\Modules\Notification\Contracts\Notification;
use Juzaweb\Modules\Notification\Models\ChannelConfig;
use Juzaweb\Modules\Notification\Http\Requests\ChannelConfigRequest;
use Juzaweb\Modules\Notification\Http\Requests\ChannelConfigActionsRequest;
use Juzaweb\Modules\Notification\Http\DataTables\ChannelConfigsDataTable;

class ChannelConfigController extends AdminController
{
    public function __construct(protected Notification $notificationManager)
    {
    }
    public function index(ChannelConfigsDataTable $dataTable)
    {
        Breadcrumb::add(__('Channel Configs'));

        $createUrl = action([static::class, 'create']);

        return $dataTable->render(
            'notification::channel-config.index',
            compact('createUrl')
        );
    }

    public function create()
    {
        Breadcrumb::add(__('Channel Configs'), admin_url('channel-configs'));

        Breadcrumb::add(__('Create Channel Config'));

        $backUrl = action([static::class, 'index']);
        $channels = collect($this->notificationManager->getChannelsArray())
            ->filter(fn ($item) => $item['config'] ?? false)
            ->map(fn ($item) => $item['label'])
            ->prepend('-- Select Channel --', '');

        return view(
            'notification::channel-config.form',
            [
                'model' => new ChannelConfig(),
                'action' => action([static::class, 'store']),
                'backUrl' => $backUrl,
                'channels' => $channels,
            ]
        );
    }

    public function edit(string $id)
    {
        Breadcrumb::add(__('Channel Configs'), admin_url('channel-configs'));

        Breadcrumb::add(__('Create Channel Configs'));

        $model = ChannelConfig::findOrFail($id);
        $backUrl = action([static::class, 'index']);
        $channels = collect($this->notificationManager->getChannelsArray())
            ->filter(fn ($item) => $item['config'] ?? false)
            ->map(fn ($item) => $item['label'])
            ->prepend('-- Select Channel --', '');

        return view(
            'notification::channel-config.form',
            [
                'action' => action([static::class, 'update'], [$id]),
                'model' => $model,
                'backUrl' => $backUrl,
                'channels' => $channels,
            ]
        );
    }

    public function store(ChannelConfigRequest $request)
    {
        $model = DB::transaction(
            function () use ($request) {
                $data = $request->validated();

                return ChannelConfig::create($data);
            }
        );

        return $this->success([
            'redirect' => action([static::class, 'index']),
            'message' => __('ChannelConfig :name created successfully', ['name' => $model->name]),
        ]);
    }

    public function update(ChannelConfigRequest $request, string $id)
    {
        $model = ChannelConfig::findOrFail($id);

        $model = DB::transaction(
            function () use ($request, $model) {
                $data = $request->validated();

                $model->update($data);

                return $model;
            }
        );

        return $this->success([
            'redirect' => action([static::class, 'index']),
            'message' => __('ChannelConfig :name updated successfully', ['name' => $model->name]),
        ]);
    }

    public function getChannelConfig(string $channelKey)
    {
        $channels = $this->notificationManager->getChannels();

        if (!isset($channels[$channelKey])) {
            return response()->json([
                'success' => false,
                'message' => 'Channel not found',
            ], 404);
        }

        $channel = $channels[$channelKey];
        $config = method_exists($channel, 'getConfig') ? $channel->getConfig() : [];

        return response()->json([
            'success' => true,
            'data' => $config,
        ]);
    }

    public function bulk(ChannelConfigActionsRequest $request)
    {
        $action = $request->input('action');
        $ids = $request->input('ids', []);

        $models = ChannelConfig::whereIn('id', $ids)->get();

        foreach ($models as $model) {
            if ($action === 'activate') {
                $model->update(['active' => true]);
            }

            if ($action === 'deactivate') {
                $model->update(['active' => false]);
            }

            if ($action === 'delete') {
                $model->delete();
            }
        }

        return $this->success([
            'message' => __('Bulk action performed successfully'),
        ]);
    }
}
