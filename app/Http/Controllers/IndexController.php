<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Product;
use App\Category;


class IndexController extends Controller
{
     public function index(){
        // $products = Product::latest()->get();
        // return view ('frontend.index',compact('products'));
        $productsAll = Product::latest()->where('status', '=', 1)->get();
        $categories = Category::with('categories')->where(['parent_id' => 0])->get();
        // return view ('frontend.index',compact('products', 'categories'));
         return view ('frontend.index',compact('productsAll', 'categories'));
    }

}
