<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com/cms
 */

namespace Juzaweb\Modules\Notification\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SentNotificationRequest extends FormRequest
{
    public function rules(): array
    {
        return [
			'title' => ['required'],
			'message' => ['required'],
			'recipient_type' => ['required'],
			'via' => ['required', 'array'],
		];
    }
}
