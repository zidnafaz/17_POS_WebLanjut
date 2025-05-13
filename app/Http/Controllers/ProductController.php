<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriModel;
use App\Models\BarangModel;
use App\DataTables\ProductDataTable;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Barryvdh\DomPDF\Facade\Pdf;

class ProductController extends Controller
{
    // public function index()
    // {
    //     $categories = KategoriModel::all();
    //     return view('product.products', compact('categories'));
    // }

    public function index()
    {
        $products = BarangModel::all();
        return view('product.index', compact('products'));
    }

    public function show($category)
    {
        // Ubah cara pencarian kategori
        $categoryModel = KategoriModel::where('kategori_kode', $category)
            ->orWhere('kategori_id', $category)
            ->first();

        if (!$categoryModel) {
            // Return response JSON jika request AJAX
            if (request()->ajax()) {
                return response()->json(['error' => 'Category not found'], 404);
            }
            abort(404, 'Category not found');
        }

        $products = BarangModel::where('kategori_id', $categoryModel->kategori_id)->get();

        if (request()->ajax()) {
            return response()->json([
                'category' => $categoryModel,
                'products' => $products
            ]);
        }

        return view('product.products-category', compact('categoryModel', 'products'));
    }

    public function dataTableIndex(ProductDataTable $dataTable)
    {
        $categories = KategoriModel::all();
        return $dataTable->render('product.index', compact('categories'));
    }

    // public function create_ajax()
    // {
    //     $categories = KategoriModel::all();
    //     return view('product.create_ajax', compact('categories'));
    // }

    public function store_ajax(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|exists:m_kategori,kategori_id',
            'barang_kode' => 'required|string|max:255',
            'barang_nama' => 'required|string|max:255',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
        ]);

        BarangModel::create([
            'kategori_id' => $request->kategori_id,
            'barang_kode' => $request->barang_kode,
            'barang_nama' => $request->barang_nama,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual,
        ]);

        return response()->json(['success' => true]);
    }

    // public function edit_ajax($id)
    // {
    //     $product = BarangModel::findOrFail($id);
    //     $categories = KategoriModel::all();
    //     return view('product.edit_ajax', compact('product', 'categories'));
    // }

    public function update_ajax(Request $request, $id)
    {
        $request->validate([
            'kategori_id' => 'required|exists:m_kategori,kategori_id',
            'barang_kode' => 'required|string|max:255',
            'barang_nama' => 'required|string|max:255',
            'harga_beli' => 'required|numeric',
            'harga_jual' => 'required|numeric',
        ]);

        $product = BarangModel::findOrFail($id);
        $product->update([
            'kategori_id' => $request->kategori_id,
            'barang_kode' => $request->barang_kode,
            'barang_nama' => $request->barang_nama,
            'harga_beli' => $request->harga_beli,
            'harga_jual' => $request->harga_jual,
        ]);

        return response()->json(['success' => true]);
    }

    public function confirm_ajax($id)
    {
        $product = BarangModel::findOrFail($id);
        return view('product.confirm_ajax', compact('product'));
    }

    public function delete_ajax($id)
    {
        $product = BarangModel::findOrFail($id);
        $product->delete();

        return response()->json(['success' => true]);
    }

    public function detail_ajax($id)
    {
        $product = BarangModel::findOrFail($id);
        return view('product.detail_ajax', compact('product'));
    }

    public function create_ajax()
    {
        $categories = KategoriModel::all();
        return view('product.create_ajax', compact('categories'));
    }

    public function edit_ajax($id)
    {
        $product = BarangModel::findOrFail($id);
        $categories = KategoriModel::all();
        return view('product.edit_ajax', compact('product', 'categories'));
    }

    public function import()
    {
        return view('product.import');
    }

    public function import_ajax(Request $request)
    {
        $request->validate([
            'file_barang' => 'required|mimes:xlsx,xls|max:2048'
        ]);

        try {
            $file = $request->file('file_barang');
            $spreadsheet = IOFactory::load($file->getRealPath());
            $sheet = $spreadsheet->getActiveSheet();
            $data = $sheet->toArray(null, true, true, true);

            $insertData = [];
            $skippedData = [];
            $errors = [];

            // Ambil semua barang_kode yang sudah ada di database sekaligus
            $existingCodes = BarangModel::pluck('barang_kode')->toArray();

            foreach ($data as $row => $values) {
                // Skip header row (assuming row 1 is header)
                if ($row == 1) continue;

                // Skip jika barang_kode sudah ada
                if (in_array($values['B'], $existingCodes)) {
                    $skippedData[] = "Baris $row: Barang dengan kode {$values['B']} sudah ada dan akan diabaikan";
                    continue;
                }

                // Validate each row (tanpa validasi unique untuk barang_kode)
                $validator = Validator::make([
                    'kategori_id' => $values['A'],
                    'barang_kode' => $values['B'],
                    'barang_nama' => $values['C'],
                    'harga_beli' => $values['D'],
                    'harga_jual' => $values['E']
                ], [
                    'kategori_id' => 'required|exists:m_kategori,kategori_id',
                    'barang_kode' => 'required|string|max:255',
                    'barang_nama' => 'required|string|max:255',
                    'harga_beli' => 'required|numeric',
                    'harga_jual' => 'required|numeric'
                ]);

                if ($validator->fails()) {
                    $errors[] = "Baris $row: " . implode(', ', $validator->errors()->all());
                    continue;
                }

                $insertData[] = [
                    'kategori_id' => $values['A'],
                    'barang_kode' => $values['B'],
                    'barang_nama' => $values['C'],
                    'harga_beli' => $values['D'],
                    'harga_jual' => $values['E'],
                    'created_at' => now(),
                    'updated_at' => now()
                ];

                // Tambahkan kode baru ke array existingCodes untuk pengecekan duplikat dalam file yang sama
                $existingCodes[] = $values['B'];
            }

            // Gabungkan skipped data dengan errors untuk informasi
            $allMessages = array_merge($skippedData, $errors);

            if (empty($insertData)) {
                return response()->json([
                    'status' => false,
                    'message' => 'Tidak ada data baru yang valid untuk diimport',
                    'info' => $allMessages
                ], 422);
            }

            // Gunakan insertOrIgnore untuk mengabaikan data yang duplicate
            $insertedCount = BarangModel::insertOrIgnore($insertData);

            $response = [
                'status' => true,
                'message' => 'Import data berhasil',
                'inserted_count' => $insertedCount,
                'skipped_count' => count($skippedData),
                'info' => $allMessages
            ];

            // Jika ada error validasi (selain duplikat)
            if (!empty($errors)) {
                $response['error_count'] = count($errors);
            }

            return response()->json($response, 200, ['Content-Type' => 'application/json']);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Terjadi kesalahan saat memproses file',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function export_excel()
    {
        // Ambil data barang yang akan di export
        $barang = BarangModel::select('kategori_id', 'barang_kode', 'barang_nama', 'harga_beli', 'harga_jual')
            ->orderBy('kategori_id')
            ->with('kategori')
            ->get();

        // Create new Spreadsheet object
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Set header
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Kode Barang');
        $sheet->setCellValue('C1', 'Nama Barang');
        $sheet->setCellValue('D1', 'Harga Beli');
        $sheet->setCellValue('E1', 'Harga Jual');
        $sheet->setCellValue('F1', 'Kategori');

        // Style header
        $sheet->getStyle('A1:F1')->getFont()->setBold(true);

        // Fill data
        $no = 1;
        $baris = 2;
        foreach ($barang as $item) {
            $sheet->setCellValue('A' . $baris, $no);
            $sheet->setCellValue('B' . $baris, $item->barang_kode);
            $sheet->setCellValue('C' . $baris, $item->barang_nama);
            $sheet->setCellValue('D' . $baris, $item->harga_beli);
            $sheet->setCellValue('E' . $baris, $item->harga_jual);
            $sheet->setCellValue('F' . $baris, $item->kategori->kategori_nama);
            $baris++;
            $no++;
        }

        // Auto size columns
        foreach (range('A', 'F') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }

        // Set title sheet
        $sheet->setTitle("Data Barang");

        // Create writer and output
        $writer = \PhpOffice\PhpSpreadsheet\IOFactory::createWriter($spreadsheet, 'Xlsx');
        $filename = 'Data Barang ' . date("Y-m-d H:i:s") . '.xlsx';

        // Set headers
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $filename . '"');
        header('Cache-Control: max-age=0');
        header('Cache-Control: max-age=1');
        header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
        header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT');
        header('Cache-Control: cache, must-revalidate');
        header('Pragma: public');

        $writer->save('php://output');
        exit;
    }

    public function export_pdf()
    {
        // Get data to export
        $barang = BarangModel::select('kategori_id', 'barang_kode', 'barang_nama', 'harga_beli', 'harga_jual')
            ->orderBy('kategori_id')
            ->orderBy('barang_kode')
            ->with('kategori')
            ->get();

        // Load the PDF library
        $pdf = Pdf::loadView('product.export_pdf', [
            'barang' => $barang
        ]);

        // Set paper size and orientation
        $pdf->setPaper('a4', 'portrait');

        // Enable remote assets if needed
        $pdf->setOption('isRemoteEnabled', true);

        $pdf->setOption('isHtml5ParserEnabled', true);
        $pdf->setOption('chroot', base_path('public'));

        // Render and stream the PDF
        return $pdf->stream('Data Barang ' . date('Y-m-d H:i:s') . '.pdf');
    }
}
