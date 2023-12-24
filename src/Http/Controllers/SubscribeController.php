<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\Notification\Http\Controllers;

use Illuminate\Contracts\Validation\Validator as ValidatorContract;
use Illuminate\Support\Facades\Validator;
use Juzaweb\Backend\Http\Controllers\Backend\PageController;
use Juzaweb\CMS\Abstracts\DataTable;
use Juzaweb\CMS\Traits\ResourceController;
use Juzaweb\Notification\Http\Datatable\JwNotificationSubscribeDatatable;
use Juzaweb\Notification\Models\JwNotificationSubscribe;

class SubscribeController extends PageController
{
    use ResourceController;

    protected string $viewPrefix = 'jw_notification::subscribe';

    protected function getDataTable(...$params): DataTable
    {
        return new JwNotificationSubscribeDatatable();
    }

    protected function validator(array $attributes, ...$params): ValidatorContract
    {
        return Validator::make(
            $attributes,
            [
                // Rules
            ]
        );
    }

    protected function getModel(...$params): string
    {
        return JwNotificationSubscribe::class;
    }

    protected function getTitle(...$params): string
    {
        return trans('jw_notification::content.jw_notification_subscribe');
    }
}