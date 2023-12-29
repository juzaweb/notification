<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\Notification\Http\Controllers\Backend;

use Illuminate\Contracts\Validation\Validator as ValidatorContract;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Juzaweb\Backend\Http\Controllers\Backend\PageController;
use Juzaweb\CMS\Abstracts\DataTable;
use Juzaweb\CMS\Traits\ResourceController;
use Juzaweb\Notification\Http\Datatable\EmailSubscribeDatatable;
use Juzaweb\Notification\Models\EmailSubscribe;

class SubscribeController extends PageController
{
    use ResourceController;

    protected string $viewPrefix = 'jw_notification::email_subscribe';

    protected function getDataTable(...$params): DataTable
    {
        return new EmailSubscribeDatatable();
    }

    protected function validator(array $attributes, ...$params): ValidatorContract
    {
        return Validator::make(
            $attributes,
            [
                'email' => [
                    'required',
                    'email:rfc,dns',
                    Rule::modelUnique(EmailSubscribe::class, 'email'),
                ],
            ]
        );
    }

    protected function getModel(...$params): string
    {
        return EmailSubscribe::class;
    }

    protected function getTitle(...$params): string
    {
        return trans('jw_notification::content.subscribes');
    }
}
