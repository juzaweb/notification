<form method="post" action="{{ route('admin.setting.save') }}" class="form-ajax">
    <input type="hidden" name="form" value="notification">

    <div class="row">
        <div class="col-md-12">
            @component('juzaweb::components.form_select', [
                'label' => trans('method'),
                'name' => 'notification_method',
                'options' => [
                    'sync' => 'sync',
                    'queue' =>
                    'queue',
                    'cron' => 'cron'
                ],
            ])
            @endcomponent


        </div>

        <div class="col-md-4">
            <button type="submit" class="btn btn-success"><i class="fa fa-save"></i> {{ trans('juzaweb::app.save') }}</button>
        </div>
    </div>

</form>