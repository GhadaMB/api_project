<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DataTables;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function returnAjaxData()
    {
        $products = Auth::user()->products;
        return DataTables::of($products)
            ->addIndexColumn()
            ->editColumn('name', function($item) {
                return $item->name;
            })
            ->editColumn('description', function ($item) {
                return $item->description;
            })
            ->editColumn('image', function($item) {
                return $item->image;
            })
            ->rawColumns(['name','description', 'image'])
            ->make(true);
    }

}
