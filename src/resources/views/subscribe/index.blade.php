@extends('cms::layouts.backend')

@section('content')
    <div class="row">
        <div class="col-md-4">
            @component('cms::components.form', [

            ])

                <div class="row">
                    <div class="col-md-12">

                        {{ Field::text(trans('jw_notification::content.name'), 'name', []) }}

                        {{ Field::text(trans('jw_notification::content.email'), 'email', []) }}

                        <button type="submit" class="btn btn-success">{{ trans('jw_notification::content.add_subscribe') }}</button>
                    </div>
                </div>

            @endcomponent
        </div>

        <div class="col-md-8">
            {{ $dataTable->render() }}
        </div>
    </div>

@endsection
