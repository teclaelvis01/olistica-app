<?php

namespace App\DataTables;

use App\Models\OptionGroups;
use App\Traits\DataTableTrait;

use App\Models\SubCategory;
use App\Models\User;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;

class OptionsGroupsDataTable extends DataTable
{
    use DataTableTrait;
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return datatables()
            ->eloquent($query)
            ->editColumn('name', function ($option_groups) {
                return '<a class="btn-link btn-link-hover" href=' . route('option-groups.create', ['id' => $option_groups->id]) . '>' . $option_groups->name . '</a>';
            })
            ->addColumn('options', function ($option_groups) {
                $options = [];
                /**
                 * @var OptionGroups $option_groups
                 */
                $options_raw = $option_groups->options;
                $iteration = 0;
                $has_more = false;
                foreach ($options_raw as $key => $value) {
                    if($iteration >= OptionGroups::OPTION_LIMIT_ON_LIST){
                        $has_more = true;
                        break;
                    }
                    $options[] = $value;
                    $iteration ++;
                }
                return view('option_groups.options_list', compact('options','has_more'))->render();
            })
            ->addColumn('action', function ($option_groups) {
                return view('option_groups.action', compact('option_groups'))->render();
            })
            ->addIndexColumn()
            ->rawColumns(['name', 'options', 'action']);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\OptionGroups $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(OptionGroups $model)
    {
        /**
         * @var User
         */
        $user = auth()->user();
        if ($user->hasAnyRole(['admin'])) {
            $model = $model->withTrashed();
        }
        return $model->newQuery();
    }
    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::make('DT_RowIndex')
                ->searchable(false)
                ->title(__('messages.no'))
                ->orderable(false),
            Column::make('name'),
            Column::make('options'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }
}
