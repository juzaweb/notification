<?php

namespace Juzaweb\Notification\Http\Controllers\Backend;

use Exception;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Juzaweb\Backend\Http\Controllers\Backend\PageController;
use Juzaweb\Backend\Models\ManualNotification;
use Juzaweb\CMS\Abstracts\DataTable;
use Juzaweb\CMS\Models\User;
use Juzaweb\CMS\Traits\ResourceController;
use Juzaweb\Notification\Http\Datatable\NotificationDatatable;
use Juzaweb\Notification\Http\Requests\NotificationRequest;

class NotificationController extends PageController
{
    use ResourceController {
        getDataForForm as DataForForm;
    }

    protected string $viewPrefix = 'jw_notification::notification';

    protected function getDataTable(...$params): DataTable
    {
        return app()->make(NotificationDatatable::class);
    }

    public function create(...$params): Factory|View
    {
        $this->addBreadcrumb(
            [
                'title' => trans('cms::app.notifications'),
                'url' => route('admin.notification.index'),
            ]
        );

        $model = new ManualNotification();
        $vias = $this->getVias();
        return view(
            'jw_notification::notification.form',
            [
                'title' => trans('cms::app.add_new'),
                'model' => $model,
                'vias' => $vias,
            ]
        );
    }

    public function edit(...$params): Factory|View
    {
        $this->addBreadcrumb(
            [
                'title' => trans('cms::app.notifications'),
                'url' => route('admin.notification.index'),
            ]
        );

        $id = $params[0];
        $vias = $this->getVias();
        $model = ManualNotification::findOrFail($id);
        $users = User::whereIn('id', explode(',', $model->users))
            ->get(['id', 'name']);

        return view(
            'jw_notification::notification.form',
            [
                'title' => $model->data['subject'] ?? '',
                'model' => $model,
                'users' => $users,
                'vias' => $vias,
            ]
        );
    }

    public function store(NotificationRequest $request, ...$params): JsonResponse|RedirectResponse
    {
        $via = $request->post('via');
        $via = implode(',', $via);

        $users = $request->post('users');
        $users = $users ? implode(',', $users) : -1;

        DB::beginTransaction();
        try {
            $model = new ManualNotification();
            $model->fill($request->all());
            $model->setAttribute('status', 4);
            $model->setAttribute('method', $via);
            $model->setAttribute('users', $users);
            $model->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return $this->success(
            [
                'message' => trans('cms::app.saved_successfully'),
                'redirect' => action([static::class, 'index']),
            ]
        );
    }

    public function update(NotificationRequest $request, ...$params): JsonResponse|RedirectResponse
    {
        $id = $params[0];
        $via = $request->post('via');
        $via = implode(',', $via);

        $users = $request->post('users');
        $users = $users ? implode(',', $users) : -1;

        DB::beginTransaction();
        try {
            $model = ManualNotification::findOrFail($id);
            $model->fill($request->all());
            $model->setAttribute('method', $via);
            $model->setAttribute('users', $users);
            $model->save();
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }

        return $this->success(
            [
                'message' => trans('cms::app.save_successfully'),
                'redirect' => action([static::class, 'index'])
            ]
        );
    }

    protected function getVias(): Collection
    {
        return collect(config('juzaweb.notification.via', []));
    }

    protected function validator(array $attributes, ...$params): Validator|array
    {
        return [];
    }

    protected function getModel(...$params): string
    {
        return ManualNotification::class;
    }

    protected function getTitle(...$params): string
    {
        return trans('cms::app.notifications');
    }

    protected function getDataForForm(Model $model, ...$params): array
    {
        $data = $this->DataForForm($model);
        $data['vias'] = $this->getVias();
        return $data;
    }
}
