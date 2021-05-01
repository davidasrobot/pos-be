<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    public function __construct() {
        $this->transaction = new Transaction();
        $this->customer = new Customer();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $transaction = $this->transaction->paginate(10);
        return response()->json($transaction);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'user_id' => 'required',
            'quantity' => 'required',
            'tax' => 'required',
            'total_price' => 'required',
            'customer_phone_number' => 'required',
            'product.id' => 'required'
        ]);

        $customer = $this->customer->where('phone_number', $request->customer_phone_number)->first();
        if (!$customer) {
            $customer = $this->customer->create([
                'phone_number' => $request->customer_phone_number,
                'point' => 0
            ]);
        }
        

        $transaction = $this->transaction->create([
            'user_id' => $request->user_id,
            'customer_id' => $customer->id,
            'quantity' => $request->quantity,
            'tax' => $request->tax,
            'total_price' => $request->total_price
        ]);
        $transaction->product()->attach($request->product);

        // update customer point
        switch ($transaction->total_price) {
            case $transaction->total_price >= 100000:
                $point = 10;
                break;
            case $transaction->total_price >= 200000:
                $point = 20;
                break;
            case $transaction->total_price >= 300000:
                $point = 30;
                break;
            case $transaction->total_price >= 400000:
                $point = 40;
                break;
            case $transaction->total_price >= 500000:
                $point = 50;
                break;
            default:
                $point = 0;
                break;
        }
        $customer->update([
            'point' => $point
        ]);


        return response()->json($transaction->with(['product', 'customer'])->get(), 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $transaction = $this->transaction->where('id', $id)->with(['product', 'customer'])->firstOrFail();
        return response()->json($transaction);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        // 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $transaction = $this->transaction->where('id', $id)->firstOrFail();
        $transaction->delete();
        return response()->json('success', 200);
    }
}
