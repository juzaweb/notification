@extends('core::layouts.admin')

@section('content')
    <div class="row">
        <div class="col-md-12">
            @can('Sent Notifications.create')
                <a href="{{ $createUrl }}" class="btn btn-primary">
                    <i class="fas fa-plus"></i> {{ __('Add Sent Notification') }}
                </a>
            @endcan
        </div>
    </div>

    <div class="row mt-3">
        {{-- <div class="col-md-12">
            <x-core::datatables.filters>
                <div class="col-md-3 jw-datatable_filters">

                </div>
            </x-core::datatables.filters>
        </div> --}}

        <div class="col-md-12 mt-2">
            <x-card title="{{ __('Sent Notifications') }}">
                {{ $dataTable->table() }}
            </x-card>
        </div>
    </div>
@endsection

@section('scripts')
    {{ $dataTable->scripts(null, ['nonce' => csp_script_nonce()]) }}
@endsection
