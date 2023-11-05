<?php

namespace Juzaweb\Notification\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NotificationRequest extends FormRequest
{
    public function rules(): array
    {
        $vias = array_keys(config('juzaweb.notification.via', []));

        return [
            'data.subject' => 'required',
            'via' => 'required|array|in:' . implode(',', $vias),
        ];
    }
}
