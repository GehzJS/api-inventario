<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Output;
use App\Models\Product;

class OutputController extends Controller
{
    public function loadOutputs($rows) 
    {
        $outputs = Output::with('product')->paginate($rows);
        return response()->json($outputs, 200);
    }
    
    public function getOutput($id) 
    {
        $output = Output::where('id', '=', $id)->with('product')->get();
        return response()->json($output, 200);
    }
    
    public function searchOutputsByProduct(Request $request) 
    {
        $search = $request->search;
        $product = Product::where('name', 'LIKE', "%$search%")->get();
        if (count($product) > 0) 
        {
            $result = Output::with('product')
                ->where('product_id', 'LIKE', $product[0]['id'])
                ->paginate(10);
            return response()->json($result, 200);
        }
    }

    public function saveOutput(Request $request) 
    {
        $this->validateRequest($request);
        $output = Output::create($this->filterData($request));
        $this->modifyProductStock($request);
        return response()->json($output, 201);
    }
    
    public function editOutput($id, Request $request) 
    {
        $output = Output::findOrFail($id);
        $output->update($this->filterData($request));
        return response()->json($output, 200);
    }
    
    public function deleteOutput($id) 
    {
        $output = Output::findOrFail($id);
        $output->delete();
        return response()->json($output, 200);
    }

    public function modifyProductStock(Request $request) 
    {
        $product = Product::findOrFail($request->product_id);
        $product->stock = $product->stock - $request->quantity;
        $modifiedProduct = (array) $product;
        $product->update($modifiedProduct);
    }

    public function validateRequest(Request $request) 
    {
        return $request->validate([
            'state' => 'bail|required',
            'operator' => 'required',
            'quantity' => 'required|min:1',
            'product_id' => 'required'
        ]);
    }

    public function filterData(Request $request)
    {
        $state = $request->input('state');
        return [
            'state' => $state === 'true' ? true : false,
            'operator' => $request->input('operator'),
            'quantity' => $request->input('quantity'),
            'product_id' => $request->input('product_id')
        ];
    }
}
