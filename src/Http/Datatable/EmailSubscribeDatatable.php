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
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Juzaweb\CMS\Abstracts\DataTable;
use Juzaweb\CMS\Repositories\Criterias\FilterCriteria;
use Juzaweb\CMS\Repositories\Criterias\SearchCriteria;
use Juzaweb\CMS\Repositories\Criterias\SortCriteria;
use Juzaweb\Notification\Repositories\EmailSubscribeRepository;

class EmailSubscribeDatatable extends DataTable
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
            'active' => [
                'label' => trans('jw_notification::content.name'),
                'width' => '15%',
                'formatter' => [$this, 'activeFormatter'],
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

    public function actions(): array
    {
        $actions = parent::actions();
        $actions['activate'] = trans('cms::app.activate');
        $actions['inactivate'] = trans('cms::app.inactivate');
        return $actions;
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
        return app()->make(EmailSubscribeRepository::class)
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
                    app(EmailSubscribeRepository::class)->delete($id);
                }
                break;
            case 'activate':
                foreach ($ids as $id) {
                    app(EmailSubscribeRepository::class)->update(['active' => true], $id);
                }
        }
    }

    public function activeFormatter($value, $row, $index): Factory|View
    {
        $status = $row->active ? 'active' : 'inactive';

        return view('cms::components.datatable.status', compact('status'));
    }
}
