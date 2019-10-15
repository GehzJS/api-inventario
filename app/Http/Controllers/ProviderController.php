<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Provider;

class ProviderController extends Controller
{
    public function loadProviders($rows) 
    {
        $providers = Provider::paginate($rows);
        return response()->json($providers, 200);
    }

    public function loadAllProviders() 
    {
        $providers = Provider::all();
        return response()->json($providers, 200);
    }
    
    public function getProvider($id) 
    {
        $provider = Provider::find($id);
        return response()->json($provider, 200);
    }
    
    public function searchProviders(Request $request) 
    {
        $search = $request->search;
        $result = Provider::where('name', 'LIKE', "%$search%")->get();
        return response()->json($result, 200);
    }

    public function saveProvider(Request $request) 
    {
        $this->validateRequest($request);
        $provider = Provider::create($this->filterData($request));
        return response()->json($provider, 201);
    }
    
    public function editProvider($id, Request $request) 
    {
        $provider = Provider::findOrFail($id);
        $provider->update($this->filterData($request));
        return response()->json($provider, 200);
    }
    
    public function deleteProvider($id) 
    {
        $provider = Provider::findOrFail($id);
        $provider->delete();
        return response()->json($provider, 200);
    }

    public function validateRequest(Request $request) 
    {
        return $request->validate([
            'name' => 'bail|required|string',
            'email' => 'required|string',
            'phone' => 'required|string'
        ]);
    }

    public function filterData(Request $request)
    {
        return [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone')
        ];
    }
}
