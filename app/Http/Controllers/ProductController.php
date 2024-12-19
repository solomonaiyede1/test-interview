<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function create(Request $request){
        $product= new Product();

        $product->product_name= $request->product_name;
        $product->product_quantity= $request->product_quantity;
        $product->product_price= $request->product_price;
        $product->save();
        return redirect()->back()->with('output', 'You have successfully saved a product');
    }

    public function show(){
        $product= Product::all();
        return view('welcome', ['product'=> $product]);
    }

    public function edit($id){
        $products= Product::find($id);
        return response()->json([
            'status' => 'success',
            'products' => $products
        ]);
    }

    public function update(Request $request, $id){
        $product=Product::find($id)->update([
            'product_name'=> $request->product_name,
            'product_quantity'=> $request->product_quantity,
            'product_price'=> $request->product_price,
        ]);
        return redirect()->back();
       
    }


}
