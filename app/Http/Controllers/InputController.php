<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Input;
use App\Models\Product;

class InputController extends Controller
{
    public function loadInputs($rows) 
    {
        $inputs = Input::with(['product', 'user'])->paginate($rows);
        return response()->json($inputs, 200);
    }
    
    public function getInput($id) 
    {
        $input = Input::where('id', '=', $id)->with(['product', 'user'])->get();
        return response()->json($input, 200);
    }
    
    public function searchInputsByProduct(Request $request) 
    {
        $search = $request->search;
        $product = Product::where('name', 'LIKE', "%$search%")->get();
        if (count($product) > 0) 
        {
            $result = Input::with(['product', 'user'])
                ->where('product_id', 'LIKE', $product[0]['id'])
                ->paginate(10);
            return response()->json($result, 200);
        }
    }

    public function saveInput(Request $request) 
    {
        $this->validateRequest($request);
        $input = Input::create($this->filterData($request));
        $this->modifyProductStock($request);
        return response()->json($input, 201);
    }
    
    public function editInput($id, Request $request) 
    {
        $input = Input::findOrFail($id);
        $input->update($this->filterData($request));
        return response()->json($input, 200);
    }
    
    public function deleteInput($id) 
    {
        $input = Input::findOrFail($id);
        $input->delete();
        return response()->json($input, 200);
    }

    public function modifyProductStock(Request $request) 
    {
        $product = Product::findOrFail($request->product_id);
        $product->stock = $product->stock + $request->quantity;
        $modifiedProduct = (array) $product;
        $product->update($modifiedProduct);
    }

    public function validateRequest(Request $request) 
    {
        return $request->validate([
            'total' => 'bail|required|numeric',
            'state' => 'required',
            'quantity' => 'required|min:1',
            'product_id' => 'required',
            'user_id' => 'required'
        ]);
    }

    public function filterData(Request $request)
    {
        $state = $request->input('state');
        return [
            'total' => $request->input('total'),
            'state' => $state === 'true' ? true : false,
            'quantity' => $request->input('quantity'),
            'product_id' => $request->input('product_id'),
            'user_id' => $request->input('user_id')
        ];
    }
}
