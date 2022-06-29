<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

class ProductController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:api');
    }

    public function index(Request $request)
    {
        $product = Product::where('updated_at', '!=', null)
        ->orderBy('created_at', 'desc')
        ->paginate($request->paginate);

        return response()->json([
            'success' => true,
            'product' => $product
        ]);
        
    }

    public function store(Request $request)
    {

        $this->validate($request, [
            'uuid' => 'required',
            'name' => 'required',
            'type' => 'required',
            'price' => 'required',
            'quantity' => 'required',
        ]);

        $product = Product::create([
            'uuid' => $request->uuid, 
            'name' => $request->name,
            'type' => $request->type,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'created_at' => date("Y-m-d H:i:s")
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Created data successfully',
            'movie' => $product
        ]);
    }

    public function show($id)
    {
        $product = Product::where('id', $id)->get();

        return response()->json([
            'success' => true,
            'product' => $product
        ]);
    }

    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'uuid' => 'required',
            'name' => 'required',
            'type' => 'required',
            'price' => 'required',
            'quantity' => 'required',
        ]);

        $product = Product::where('id', $id)->update([
            'uuid' => $request->uuid, 
            'name' => $request->name,
            'type' => $request->type,
            'price' => $request->price,
            'quantity' => $request->quantity,
            'updated_at' => date("Y-m-d H:i:s")
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Updated data successfully'
        ]);
    }

    public function destroy($id)
    {

        Product::findOrFail($id)->softDelete();

        return response()->json([
            'success' => true,
            'message' => "Successfully deleted"
        ]);
    }

    //
}
