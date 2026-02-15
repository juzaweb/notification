@extends('core::layouts.admin')

@section('content')
    <form action="{{ $action }}" class="form-ajax" method="post">
        @if($model->exists)
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
                    {{ Field::select(__('Channel'), 'channel_key', ['value' => $model->channel_key])->dropDownList($channels) }}

					<div id="channel-config-fields">
						<!-- Config fields will be loaded here -->
					</div>
                </x-card>
            </div>

            <div class="col-md-3">

            </div>
        </div>
    </form>
@endsection

@section('scripts')
    <script type="text/javascript" nonce="{{ csp_script_nonce() }}">
        $(function () {
            const $channelSelect = $('select[name="channel_key"]');
            const $configFieldsContainer = $('#channel-config-fields');
            const configUrl = '{{ route("admin.channel-configs.config", ":channelKey") }}';
            const existingConfig = @json($model->config ?? []);

            // Load config fields when channel changes
            $channelSelect.on('change', function() {
                const channelKey = $(this).val();

                if (!channelKey) {
                    $configFieldsContainer.html('');
                    return;
                }

                // Show loading state
                $configFieldsContainer.html('<div class="text-muted"><i class="fas fa-spinner fa-spin"></i> Loading...</div>');

                // Fetch config fields
                $.ajax({
                    url: configUrl.replace(':channelKey', channelKey),
                    method: 'GET',
                    success: function(response) {
                        if (response.success && response.data) {
                            renderConfigFields(response.data);
                        } else {
                            $configFieldsContainer.html('');
                        }
                    },
                    error: function() {
                        $configFieldsContainer.html('<div class="text-danger">Error loading config fields</div>');
                    }
                });
            });

            // Render config fields dynamically
            function renderConfigFields(config) {
                let html = '';

                $.each(config, function(key, label) {
                    const value = existingConfig[key] || '';
                    html += `
                        <div class="form-group">
                            <label class="col-form-label" for="config_${key}">${label}</label>
                            <input type="text"
                                   class="form-control"
                                   id="config_${key}"
                                   name="config[${key}]"
                                   value="${value}">
                        </div>
                    `;
                });

                $configFieldsContainer.html(html);
            }

            // Trigger change on page load if channel is already selected
            if ($channelSelect.val()) {
                $channelSelect.trigger('change');
            }
        });
    </script>
@endsection
