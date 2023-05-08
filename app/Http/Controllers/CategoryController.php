<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Image;
use App\Models\Product;
use App\Models\sub_Category;
use Illuminate\Http\Request;


class CategoryController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    public function getAllCatigories()
    {
        $Category = Category::with(['Category.SubCategory'])->get();
        return response()->json($Category);
    }
    // , 'SubCategory.Product','Product.Image'


    public function store(Request $request)
    {
        //
    }


    public function show(Category $category)
    {
        //
    }


    public function update(Request $request, Category $category)
    {
        //
    }


    public function destroy(Category $category)
    {
        //
    }
}
