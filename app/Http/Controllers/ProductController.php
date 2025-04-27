<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriModel;
use App\Models\BarangModel;
use App\DataTables\ProductDataTable;

class ProductController extends Controller
{
    public function index()
    {
        $categories = KategoriModel::all();
        return view('product.products', compact('categories'));
    }

    public function show($category)
    {
        $categoryModel = KategoriModel::where('kategori_kode', $category)->first();
        if (!$categoryModel) {
            abort(404, 'Category not found');
        }
        $products = BarangModel::where('kategori_id', $categoryModel->kategori_id)->get();
        return view('product.products-category', compact('category', 'products'));
    }

    public function dataTableIndex(ProductDataTable $dataTable)
    {
        return $dataTable->render('product.index');
    }

    // public function dataTableAjax(ProductDataTable $dataTable)
    // {
    //     return $dataTable->ajax();
    // }

    public function manage($id)
    {
        // TODO: Implement manage product logic
        return response()->json(['message' => "Manage product with ID $id"]);
    }

    public function edit($id)
    {
        // TODO: Implement edit product logic
        return response()->json(['message' => "Edit product with ID $id"]);
    }

    public function confirm($id)
    {
        // TODO: Implement confirm delete product logic
        return response()->json(['message' => "Confirm delete product with ID $id"]);
    }
}
