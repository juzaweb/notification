<?php
/**
 * JUZAWEB CMS - Laravel CMS for Your Project
 *
 * @package    juzaweb/cms
 * @author     The Anh Dang
 * @link       https://juzaweb.com
 * @license    GNU V2
 */

namespace Juzaweb\Notification\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Juzaweb\Notification\Models\EmailSubscribe;

class EmailSubscribeRequest extends FormRequest
{
    public function rules(): array
    {
        $rules = [
            'email' => [
                'required',
                'email:rfc,dns',
                Rule::modelUnique(
                    EmailSubscribe::class,
                    'email'
                ),
            ],
        ];

        if (get_config('captcha')) {
            $rules['g-recaptcha-response'] = [
                'bail',
                'required',
                'recaptcha',
            ];
        }

        return $rules;
    }
}
