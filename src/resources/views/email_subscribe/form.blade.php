@extends('cms::layouts.backend')

@section('content')
    @component('cms::components.form_resource', [
        'model' => $model
    ])

        <div class="row">
            <div class="col-md-12">

                {{ Field::text($model, 'name', ['label' => trans('jw_notification::content.name')]) }}

			    {{ Field::text($model, 'email', ['label' => trans('jw_notification::content.email')]) }}

            </div>
        </div>

    @endcomponent
@endsection
