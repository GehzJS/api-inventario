<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Provider;

class ProductController extends Controller
{
    public function loadProducts($rows) 
    {
        $products = Product::with(['provider'])->paginate($rows);
        return response()->json($products, 200);
    }

    public function loadAllProducts() 
    {
        $products = Product::all();
        return response()->json($products, 200);
    }
    
    public function getProduct($id) 
    {
        $product = Product::where('id', '=', $id)->with('provider')->get();
        return response()->json($product, 200);
    }

    public function getProductByBarcode($barcode) 
    {
        $product = Product::where('barcode', '=', $barcode)->with('provider')->get();
        return response()->json($product, 200);
    }
    
    public function searchProducts(Request $request) 
    {
        $search = $request->search;
        $result = Product::where('name', 'LIKE', "%$search%")
                            ->with('provider')->get();
        return response()->json($result, 200);
    }

    public function saveProduct(Request $request) 
    {
        $this->validateRequest($request);
        $product = Product::create($this->filterData($request));
        return response()->json($product, 201);
    }
    
    public function editProduct($id, Request $request) 
    {
        $product = Product::findOrFail($id);
        $product->update($this->filterData($request));
        return response()->json($product, 200);
    }
    
    public function deleteProduct($id) 
    {
        $product = Product::findOrFail($id);
        $product->delete();
        return response()->json($product, 200);
    }

    public function validateRequest(Request $request) 
    {
        return $request->validate([
            'name' => 'bail|required|string',
            'barcode' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'provider_id' => 'required'
        ]);
    }

    public function filterData(Request $request)
    {
        return [
            'name' => $request->input('name'),
            'barcode' => $request->input('barcode'),
            'price' => $request->input('price'),
            'stock' => $request->input('stock'),
            'provider_id' => $request->input('provider_id'),
        ];
    }
}
