<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriModel;
use App\Models\BarangModel;

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
}
