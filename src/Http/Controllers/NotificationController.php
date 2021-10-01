<?php

namespace Juzaweb\Notification\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Juzaweb\Notification\Http\Datatable\NotificationDatatable;
use Juzaweb\Notification\Http\Requests\NotificationRequest;
use Juzaweb\Http\Controllers\BackendController;
use Juzaweb\Models\User;
use Juzaweb\Notification\Models\ManualNotification;
use Juzaweb\Traits\ResourceController;

class NotificationController extends BackendController
{
    use ResourceController {
        getDataForForm as DataForForm;
    }

    protected $viewPrefix = 'juno::notification';

    protected function getDataTable()
    {
        $dataTable = new NotificationDatatable();
        return $dataTable;
    }
    
    public function create()
    {
        $this->addBreadcrumb([
            'title' => trans('juzaweb::app.notification'),
            'url' => route('admin.notification.index')
        ]);

        $model = new ManualNotification();
        $vias = $this->getVias();
        return view('juno::notification.form', [
            'title' => trans('juzaweb::app.add_new'),
            'model' => $model,
            'vias' => $vias,
        ]);
    }

    public function edit($id)
    {
        $this->addBreadcrumb([
            'title' => trans('juzaweb::app.notifications'),
            'url' => route('admin.notification.index')
        ]);

        $vias = $this->getVias();
        $model = ManualNotification::findOrFail($id);
        $users = User::whereIn('id', explode(',', $model->users))
            ->get(['id', 'name']);

        return view('juno::notification.form', [
            'title' => $model->data['subject'] ?? '',
            'model' => $model,
            'users' => $users,
            'vias' => $vias,
        ]);
    }
    
    public function store(NotificationRequest $request)
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
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->error($exception->getMessage());
        }

        return $this->success(
            trans('juzaweb::app.saved_successfully')
        );
    }

    public function update(NotificationRequest $request, $id)
    {
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
        } catch (\Exception $exception) {
            DB::rollBack();
            return $this->error($exception->getMessage());
        }

        return $this->success([
            'message' => trans('juzaweb::app.save_successfully')
        ]);
    }

    protected function getVias()
    {
        $vias = collect(get_config('notification_used', []));
        return $vias;
    }

    /**
     * Validator for store and update
     *
     * @param array $attributes
     * @return Validator|array
     */
    protected function validator(array $attributes)
    {
        return [];
    }

    /**
     * Get model resource
     *
     * @param array $params
     * @return string // namespace model
     */
    protected function getModel()
    {
        return ManualNotification::class;
    }

    /**
     * Get title resource
     *
     * @param array $params
     * @return string
     */
    protected function getTitle()
    {
        return trans('juzaweb::app.notifications');
    }

    protected function getDataForForm($model)
    {
        $data = $this->DataForForm($model);
        $data['vias'] = $this->getVias();
        return $data;
    }
}
