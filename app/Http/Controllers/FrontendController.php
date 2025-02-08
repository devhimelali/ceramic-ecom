<?php

namespace App\Http\Controllers;

use App\Enum\StatusEnum;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Attribute;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function home()
    {
        $data = [
            'active' => 'home',
            'brands' => Brand::where('status', StatusEnum::ACTIVE)->latest()->limit(15)->get(),
        ];
        return view('frontend.home', $data);
    }


    public function allCategories()
    {
        $categories = Category::where('is_active', 1)->paginate(10);

        return view('frontend.categories', [
            'active' => 'allCategories',
            'categories' => $categories
        ]);
    }

    public function allProducts()
    {
        $data = [
            'active' => 'products',
            'attributes' => Attribute::with(['values' => function ($query) {
                $query->where('status', StatusEnum::ACTIVE)
                    ->whereNotNull('value');
            }])->get(),
        ];

        return view('frontend.products', $data);
    }
}
