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
use Juzaweb\Notification\Repositories\SubscribeRepository;

class SubscribeDatatable extends DataTable
{
    /**
     * Columns datatable
     *
     * @return array
     */
    public function columns(): array
    {
        return [
            'email' => [
                'label' => trans('jw_notification::content.email'),
                'formatter' => [$this, 'rowActionsFormatter'],
            ],
            'name' => [
                'label' => trans('jw_notification::content.name'),
                'width' => '25%',
            ],
            'created_at' => [
                'label' => trans('Subscribed at'),
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
        return app()->make(SubscribeRepository::class)
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
                    app(SubscribeRepository::class)->delete($id);
                }
                break;
        }
    }
}
