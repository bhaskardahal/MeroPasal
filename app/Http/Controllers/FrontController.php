<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ProductsAttribute;
use App\Category;
use App\Product;
use App\ProductsImage;


class FrontController extends Controller
{
    public function products($slug = null){
        $countCategory = Category::where(['slug' => $slug])->count();
        if($countCategory == 0){
            abort(404);
        }
//        Get all the categories and sub categories
        $categories = Category::with('categories')->where(['parent_id' => 0])->get();
        $categoriesDetails = Category::where(['slug' => $slug])->first();
        if($categoriesDetails->parent_id == 0){
//            if slug is main category
            $subCategories = Category::where(['parent_id' => $categoriesDetails->id])->get();
            foreach($subCategories as $subcat){
                $cat_ids[] = $subcat->id;
            }
            $productsAll = Product::whereIn('category_id', $cat_ids)->get();
            $productsAll = json_decode(json_encode($productsAll));
        } else {
//            if slug is subcategory
            $productsAll = Product::where(['category_id' => $categoriesDetails->id])->get();
        }
        return view ('frontend.products.listing', compact('categoriesDetails', 'productsAll', 'categories'));
    }
    public function product($id = null){
        
         $productDetails = Product::with('attributes')->where('id', $id)->first();
        $categories = Category::with('categories')->where(['parent_id' => 0])->get();
        $productAltImages = ProductsImage::where(['product_id' => $id])->get();
        $relatedProducts = Product::where('id', '!=', $id)->where(['category_id' => $productDetails->category_id])->get();
        $total_stock = ProductsAttribute::where('product_id', $id)->sum('stock');

        return view ('frontend.products.detail', compact('productDetails', 'categories', 'productAltImages', 'total_stock', 'relatedProducts'));
    }

}
