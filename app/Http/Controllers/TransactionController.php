<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;
use App\Models\Product;

class TransactionController extends Controller
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

    public function index()
    {
        $transaction = Transaction::where('user_id', auth()->user()->id);

        return response()->json([
            'success' => true,
            'transaction' => $transaction
        ]);
        
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'uuid' => 'required',
            'user_id' => 'required',
            'product_id' => 'required',
            'amount' => 'required',
        ]);

        $qty = Product::where('id', $request->product_id)->first();

        if($qty->quantity <= 0){
            return response()->json([
                'message' => "Stok barang kosong"
            ]);
        }
        else{
            
            $price = Product::select('price')->where('id', $request->product_id)->first();

            $tax = (10/100) * $price->price;
            $admin_fee = (5/100) * $price->price + $tax;
            $total = $price->price + $tax + $admin_fee;
            
            $transaction = Transaction::create([
                'uuid' => $request->uuid, 
                'user_id' => $request->user_id,
                'product_id' => $request->product_id,
                'amount' => $request->amount,
                'tax' => $tax,
                'admin_fee' => $admin_fee,
                'total' => $total,
                'created_at' => date("Y-m-d H:i:s")
            ]);

            Product::where('id', $request->product_id)->update([
                'quantity' => $qty->quantity - $request->amount
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Created data successfully',
                'transaction' => $transaction
            ]);

        
        }
        // dd($admin_fee);

    }

    public function show($id)
    {
        $transaction = Transaction::where('id', $id)->get();

        return response()->json([
            'success' => true,
            'transaction' => $transaction
        ]);
    }

}
