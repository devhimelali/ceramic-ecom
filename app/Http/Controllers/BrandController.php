<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BrandController extends Controller
{
    public function index()
    {
        $data = [
            'active' => 'brand'
        ];
        return view('admin.brand.brand-index', $data);
    }
}
