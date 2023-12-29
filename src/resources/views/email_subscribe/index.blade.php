@extends('cms::layouts.backend')

@section('content')
    <div class="row">
        <div class="col-md-3 pt-4">
            @component('cms::components.form', [
                'success' => 'submit_success',
            ])

                <div class="row">
                    <div class="col-md-12">

                        {{ Field::text(trans('jw_notification::content.name'), 'name', []) }}

                        {{ Field::text(trans('jw_notification::content.email'), 'email', ['required' => true, 'data' => ['rule-email' => 1]]) }}

                        <button type="submit" class="btn btn-success">
                            {{ trans('jw_notification::content.add_subscribe') }}
                        </button>
                    </div>
                </div>

            @endcomponent
        </div>

        <div class="col-md-9">
            {{ $dataTable->render() }}
        </div>
    </div>

    <script type="text/javascript">
        function submit_success(form, response) {
            form[0].reset();
            table.refresh();
            form.find("button[type=submit]").prop('disabled', false);
            return false;
        }
    </script>

@endsection
