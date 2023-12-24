<?php
/**
 * JUZAWEB CMS - The Best CMS for Laravel Project
 *
 * @package    juzaweb/juzacms
 * @author     Juzaweb Team <admin@juzaweb.com>
 * @link       https://juzaweb.com
 * @license    MIT
 */

namespace Juzaweb\Notification\Http\Datatable;

use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Database\Eloquent\Builder;
use Juzaweb\CMS\Abstracts\DataTable;
use Juzaweb\CMS\Repositories\Criterias\FilterCriteria;
use Juzaweb\CMS\Repositories\Criterias\SearchCriteria;
use Juzaweb\CMS\Repositories\Criterias\SortCriteria;
use Juzaweb\Notification\Repositories\JwNotificationSubscribeRepository;

class JwNotificationSubscribeDatatable extends DataTable
{
    /**
     * Columns datatable
     *
     * @return array
     */
    public function columns(): array
    {
        return [
            'name' => [
                'label' => trans('jw_notification::content.name'),
                'formatter' => [$this, 'rowActionsFormatter'],
            ],
            'email' => [
                'label' => trans('jw_notification::content.email'),
            ],
            'user_id' => [
                'label' => trans('jw_notification::content.user_id'),
            ],
            'created_at' => [
                'label' => trans('cms::app.created_at'),
                'width' => '15%',
                'align' => 'center',
                'formatter' => function ($value, $row, $index) {
                    return jw_date_format($row->created_at);
                }
            ]
        ];
    }

    /**
     * Query data datatable
     *
     * @param  array  $data
     * @return Builder
     * @throws BindingResolutionException
     */
    public function query(array $data): Builder
    {
        return app()->make(JwNotificationSubscribeRepository::class)
            ->pushCriteria(new SearchCriteria($data))
            ->pushCriteria(new FilterCriteria($data))
            ->pushCriteria(new SortCriteria($data))
            ->getQuery();
    }

    public function bulkActions($action, $ids): void
    {
        switch ($action) {
            case 'delete':
                foreach ($ids as $id) {
                    app(JwNotificationSubscribeRepository::class)->delete($id);
                }
                break;
        }
    }
}
