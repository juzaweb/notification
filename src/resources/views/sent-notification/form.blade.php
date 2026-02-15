@extends('core::layouts.admin')

@section('content')
    <form action="{{ $action }}" class="form-ajax" method="post">
        @if ($model->exists)
            @method('PUT')
        @endif

        <div class="row">
            <div class="col-md-12">
                <a href="{{ $backUrl }}" class="btn btn-warning">
                    <i class="fas fa-arrow-left"></i> {{ __('Back') }}
                </a>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> {{ __('Save') }}
                </button>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col-md-9">
                <x-card title="{{ __('Information') }}">
                    {{ Field::text(__('Title'), 'title', ['value' => $model->title]) }}

                    {{ Field::text(__('Message'), 'message', ['value' => $model->message]) }}

                    {{ Field::select(__('Recipient Type'), 'recipient_type', [
                        'options' => $recipientTypes,
                        'value' => $model->recipient_type
                    ]) }}

                    {{ Field::text(__('Via'), 'via', ['value' => $model->via]) }}

                    {{ Field::text(__('Sent At'), 'sent_at', ['value' => $model->sent_at]) }}
                </x-card>
            </div>

            <div class="col-md-3">
                <x-card title="{{ __('Notification Channels') }}">
                    @foreach ($channels as $key => $label)
                        <div class="form-check mb-2">
                            <input class="form-check-input"
                                   type="checkbox"
                                   name="via[]"
                                   value="{{ $key }}"
                                   id="channel-{{ $key }}"
                                   @if ($model->exists && in_array($key, $model->via ?? [])) checked @endif>
                            <label class="form-check-label" for="channel-{{ $key }}">
                                {{ $label }}
                            </label>
                        </div>
                    @endforeach
                </x-card>
            </div>
        </div>
    </form>
@endsection

@section('scripts')
    <script type="text/javascript" nonce="{{ csp_script_nonce() }}">
        $(function() {
            //
        });
    </script>
@endsection
