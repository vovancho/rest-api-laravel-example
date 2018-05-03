<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class HomeController extends Controller
{
//    public function index()
//    {
//        $products = Product::paginate(10);
//
//        return view('home', ['products' => $products]);
//    }

    public function index()
    {
        return view('datatable');
    }

    public function getData()
    {
        $products = Product::select(['id', 'name', 'price', 'created_at', 'updated_at']);

        return Datatables::of($products)->make();
    }
}
