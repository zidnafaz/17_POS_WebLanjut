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
            ->addColumn('kategori', function ($row) {
                return $row->kategori ? $row->kategori->kategori_nama : '';
            })
            ->filterColumn('kategori', function ($query, $keyword) {
                $query->whereHas('kategori', function ($q) use ($keyword) {
                    $q->where('kategori_nama', 'like', "%{$keyword}%");
                });
            })
            ->addColumn('aksi', function ($row) {
                $detailUrl = route('products.detail_ajax', $row->barang_id);
                $editUrl = route('products.edit_ajax', $row->barang_id);
                $deleteUrl = route('products.confirm_ajax', $row->barang_id);

                return '
                    <div class="d-flex justify-content-center gap-2" style="white-space: nowrap;">
                        <button onclick="modalAction(\'' . $detailUrl . '\')" class="btn btn-sm btn-info" style="margin-left: 5px;">
                            <i class="fas fa-info-circle"></i> Detail
                        </button>
                        <button onclick="modalAction(\'' . $editUrl . '\')" class="btn btn-sm btn-primary" style="margin-left: 5px;">
                            <i class="fas fa-edit"></i> Ubah
                        </button>
                        <button onclick="modalAction(\'' . $deleteUrl . '\')" class="btn btn-sm btn-danger" style="margin-left: 5px;">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </div>
                ';
            })
            ->rawColumns(['aksi']) // Penting: supaya HTML di kolom aksi tidak di-escape
            ->setRowId('barang_id');
    }

    /**
     * Get the query source of dataTable.
     */
    public function query(BarangModel $model): QueryBuilder
    {
        $query = $model->newQuery()
            ->select('m_barang.*')
            ->leftJoin('m_kategori', 'm_barang.kategori_id', '=', 'm_kategori.kategori_id');

        if (request()->has('kategori_id') && request('kategori_id') != '') {
            $query->where('m_barang.kategori_id', request('kategori_id'));
        }

        return $query;
    }

    /**
     * Optional method if you want to use the html builder.
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
            ->setTableId('product-table')
            ->columns($this->getColumns())
            ->ajax([
                'url' => route('products.index'),
                'data' => "function(d) { d.kategori_id = $('#kategori_id').val(); }"
            ])
            ->orderBy(0, 'desc')
            // ->selectStyleSingle()
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
            Column::make('barang_id')->title('Barang ID'),
            Column::make('kategori')
                ->title('Kategori')
                ->orderable(true)
                ->searchable(true)
                ->data('kategori')
                ->name('m_kategori.kategori_nama'),
            Column::make('barang_kode')->title('Barang Kode'),
            Column::make('barang_nama')->title('Barang Nama'),
            Column::make('harga_jual')->title('Harga Jual'),
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
