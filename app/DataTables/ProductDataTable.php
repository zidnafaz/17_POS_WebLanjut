<?php

namespace App\DataTables;

use App\Models\KategoriModel;
use App\Models\BarangModel;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ProductDataTable extends DataTable
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
                $manageUrl = url('products/' . $row->kategori_kode);

                return '
                    <div class="d-flex justify-content-center" style="white-space: nowrap;">
                        <a href="' . $manageUrl . '" class="btn btn-sm btn-info" style="margin-left: 5px;">
                            <i class="fas fa-cogs"></i> Kelola Produk
                        </a>
                    </div>
                ';
            })
            ->rawColumns(['aksi']) // Important: allow HTML in aksi column
            ->setRowId('kategori_id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(KategoriModel $model): QueryBuilder
    {
        return $model->newQuery()->distinct();
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('product-table')
            ->columns($this->getColumns())
            ->minifiedAjax()
            ->orderBy(1)
            ->selectStyleSingle()
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
            Column::make('kategori_kode')->title('Kategori Kode')->orderable(false)->searchable(false),
            Column::make('kategori_nama')->title('Kategori Nama')->orderable(false)->searchable(false),
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
        return 'Product_' . date('YmdHis');
    }
}
