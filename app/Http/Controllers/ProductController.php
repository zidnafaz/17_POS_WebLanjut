<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriModel;
use App\Models\BarangModel;
use App\DataTables\ProductDataTable;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

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
}
