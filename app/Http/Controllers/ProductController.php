<?php

namespace App\Http\Controllers;


use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index(){
        $products = Product::all();
        return response()->json([
            'success' => true,
            'message' => "Products List",
            'products' => $products
        ]);
    }

    public function store(Request $request){
        $validatedData = $request->validate([
            'name' => 'required|string',
            'reference' => 'required|string',
            'description' => 'required|string',
        ]);
        $product = Product::create($validatedData);
        return response()->json([
            'success' => true,
            'message' => "Product created successfully.",
            'data' => $product
        ]);
    }

    public function update(Request $request, $id){
        $validatedData = $request->validate([
            'name' => 'string',
            'reference' => 'string',
            'description' => 'string',
        ]);
        $product = Product::findOrFail($id);
        $product->update($validatedData);
        return response()->json([
            'success' => true,
            'message' => "Product updated successfully.",
            'data' => $product
        ], 200);
    }

    public function destroy($id){
        $validatedData = ['id' => $id];
        $validator = Validator::make($validatedData, [
            'id' => 'required|exists:products,id',
        ]);
        if ($validator->fails()){
            return response()->json([
                'success' => false,
                'message' => "ID de producto no válido",
                'data' => null
            ], 400);
        }
        $product = Product::findOrFail($id);
        $product->delete();
        return response()->json([
            'success' => true,
            'message' => "Product deleted successfully.",
            'data' => ''
        ], 200);
    }

    
}
