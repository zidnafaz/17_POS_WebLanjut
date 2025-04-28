<?php

namespace App\DataTables;

use App\Models\LevelModel;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class LevelDataTable extends DataTable
{
    /**
     * Build the DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->addColumn('aksi', function ($row) {
                $detailUrl = route('level.detail_ajax', $row->level_id);
                $editUrl = route('level.edit_ajax', $row->level_id);
                $deleteUrl = route('level.confirm_ajax', $row->level_id);

                $buttons = <<<EOT
<div class="d-flex justify-content-center gap-2" style="white-space: nowrap;">
    <button onclick="modalAction('{$detailUrl}')" class="btn btn-sm btn-info" style="margin-left: 5px;">
        <i class="fas fa-info-circle"></i> Detail
    </button>
    <button onclick="modalAction('{$editUrl}')" class="btn btn-sm btn-primary" style="margin-left: 5px;">
        <i class="fas fa-edit"></i> Ubah
    </button>
    <button onclick="modalAction('{$deleteUrl}')" class="btn btn-sm btn-danger" style="margin-left: 5px;">
        <i class="fas fa-trash"></i> Hapus
    </button>
</div>
EOT;

                return $buttons;
            })
            ->rawColumns(['aksi']) // Important: allow HTML in aksi column
            ->setRowId('level_id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(LevelModel $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('level-table')
            ->columns($this->getColumns())
            ->ajax([
                'url' => route('level.index'),
            ])
            ->orderBy(1)
            ->buttons([
                Button::make('excel'),
                Button::make('csv'),
                Button::make('pdf'),
                Button::make('print'),
                Button::make('reset'),
                Button::make('reload')
            ]);
    }

    /**
     * Get the dataTable columns definition.
     */
    public function getColumns(): array
    {
        return [
            Column::make('level_kode')->title('Kode Level'),
            Column::make('level_nama')->title('Nama Level'),
            Column::computed('aksi')
                ->exportable(false)
                ->printable(false)
                ->addClass('text-center'),
        ];
    }

    /**
     * Get the filename for export.
     */
    protected function filename(): string
    {
        return 'Level_' . date('YmdHis');
    }
}
