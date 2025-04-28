<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriModel;
use App\Models\BarangModel;
use App\DataTables\ProductDataTable;

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
}
