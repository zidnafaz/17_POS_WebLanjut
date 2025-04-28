<?php

namespace App\DataTables;

use App\Models\SuplierModel;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class SuplierDataTable extends DataTable
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
                $detailUrl = route('suplier.detail_ajax', $row->id_suplier);
                $editUrl = route('suplier.edit_ajax', $row->id_suplier);
                $deleteUrl = url(route('suplier.confirm_ajax', $row->id_suplier));

                return "
                    <div class=\"d-flex justify-content-center gap-2\" style=\"white-space: nowrap;\">
                        <button onclick=\"modalAction('{$detailUrl}')\" class=\"btn btn-sm btn-info\" style=\"margin-left: 5px;\">
                            <i class=\"fas fa-info-circle\"></i> Detail
                        </button>
                        <button onclick=\"modalAction('{$editUrl}')\" class=\"btn btn-sm btn-primary\" style=\"margin-left: 5px;\">
                            <i class=\"fas fa-edit\"></i> Ubah
                        </button>
                        <button onclick=\"modalAction('{$deleteUrl}')\" class=\"btn btn-sm btn-danger\" style=\"margin-left: 5px;\">
                            <i class=\"fas fa-trash\"></i> Hapus
                        </button>
                    </div>
                ";
            })
            ->rawColumns(['aksi'])
            ->setRowId('id_suplier');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(SuplierModel $model): QueryBuilder
    {
        return $model->newQuery();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('suplier-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
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
            Column::make('id_suplier')->title('Suplier ID'),
            Column::make('kode_suplier')->title('Suplier Kode'),
            Column::make('nama_suplier')->title('Suplier Nama'),
            Column::make('no_telepon')->title('No Telepon'),
            Column::make('alamat')->title('Alamat'),
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
        return 'Suplier_' . date('YmdHis');
    }
}
