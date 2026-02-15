<?php

namespace Juzaweb\Modules\Notification\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Juzaweb\Modules\Core\Rules\AllExist;

class SentNotificationActionsRequest extends FormRequest
{
    public function rules()
    {
        return [
            'action' => ['required', 'in:delete,sent'],
            'ids' => ['required', 'array', 'min:1', new AllExist('sent_notifications', 'id')],
        ];
    }
}
