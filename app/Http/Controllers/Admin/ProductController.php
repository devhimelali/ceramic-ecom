<?php

namespace App\Http\Controllers\Admin;

use App\Models\Brand;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Product::with(['images', 'category', 'brand', 'attributes' => function ($query) {
                $query->with('values');
            }])->orderBy('id', 'desc')->get();

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('image', function ($row) {
                    $image = $row->images->where('type', 'thumbnail')->first();
                    $imageUrl = $row->image
                        ? asset('storage/' . $row->image)
                        : "https://ui-avatars.com/api/?name=" . urlencode($row->name);

                    return '<img class="rounded-circle header-profile-user" src="' . $imageUrl . '" alt="' . e($row->name) . '" width="50" height="50">';
                })
                ->addColumn('category', function ($row) {
                    return $row->category->name;
                })
                ->addColumn('brand', function ($row) {
                    return $row->brand->name;
                })
                ->addColumn('action', function ($row) {
                    return view('admin.product.action', compact('row'));
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $data = [
            'active' => 'products'
        ];
        return view('admin.product.index', $data);
    }

    public function create()
    {
        $categories = Category::with('children')->whereNull('parent_id')->orderBy('name', 'asc')->get();
        $brands = Brand::orderBy('name', 'asc')->get(); 
        $data = [
            'categories' => $categories,
            'brands' => $brands,
            'active' => 'products'
        ];
        return view('admin.product.create', $data);
    }
}
