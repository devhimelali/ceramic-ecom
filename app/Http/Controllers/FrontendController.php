<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function home()
    {
        $data = [
            'active' => 'home'
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
}
