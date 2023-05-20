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
            ->editColumn('name', function ($subcategory) {
                return '<a class="btn-link btn-link-hover" href=' . route('subcategory.create', ['id' => $subcategory->id]) . '>' . $subcategory->name . '</a>';
            })
            ->addColumn('action', function ($subcategory) {
                return view('subcategory.action', compact('subcategory'))->render();
            })
            ->addIndexColumn()
            ->rawColumns(['name', 'action']);

    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\OptionGroups $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(OptionGroups $model)
    {
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
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }
}
