<?php

namespace App\DataTables;

use App\Models\Options;
use App\Models\User;
use App\Traits\DataTableTrait;

use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;

class OptionsDataTable extends DataTable
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
            ->editColumn('name', function ($options) {
                return '<a class="btn-link btn-link-hover" href=' . route('options.create', ['id' => $options->id]) . '>' . $options->name . '</a>';
            })
            ->addColumn('action', function ($options) {
                return view('options.action', compact('options'))->render();
            })
            ->addIndexColumn()
            ->rawColumns(['name', 'action']);

    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Models\Options $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Options $model)
    {
        /**
         * @var User
         */
        $user = auth()->user();
        if($user->hasAnyRole(['admin'])){
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
            Column::make('price'),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->width(60)
                ->addClass('text-center'),
        ];
    }
}
