<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function list(Request $request) {
        return view('product-list', [
            'page_title' => 'Список продуктов'.($request->page ? ', страница '.$request->page : ''),
            'products' => Product::orderby('name')->paginate(config('prj.products_on_page'))
        ]);
    }

    public function update(Request $request)
    {
        $validator = $request->validate([
            'price' => 'required|numeric'
        ]);

        $product = Product::find($request->id);
        $product->price = $request->price;
        $product->save();

        return  response()->json($product, 200);
    }
}
